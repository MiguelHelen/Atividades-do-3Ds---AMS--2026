package com.example.gestorconvenios

import android.Manifest
import android.app.Activity
import android.content.Intent
import android.content.pm.PackageManager
import android.net.Uri
import android.os.Build
import android.os.Bundle
import android.text.Editable
import android.text.TextWatcher
import android.widget.*
import androidx.activity.result.contract.ActivityResultContracts
import androidx.appcompat.app.AppCompatActivity
import androidx.appcompat.widget.Toolbar
import androidx.core.content.ContextCompat
import com.google.android.material.textfield.TextInputEditText
import com.google.android.material.textfield.TextInputLayout

class CadastroConvenioActivity : AppCompatActivity() {

    private lateinit var dbHelper: DatabaseHelper
    private var documentoUri: String = ""
    private var convenioId: Long = -1

    // Launcher moderno para selecionar arquivo
    private val selecionarArquivo = registerForActivityResult(
        ActivityResultContracts.StartActivityForResult()
    ) { result ->
        if (result.resultCode == Activity.RESULT_OK) {
            result.data?.data?.let { uri ->
                try {
                    contentResolver.takePersistableUriPermission(
                        uri, Intent.FLAG_GRANT_READ_URI_PERMISSION
                    )
                } catch (e: Exception) {
                    // ignora se não conseguir persistir
                }
                documentoUri = uri.toString()
                val nome = uri.lastPathSegment ?: uri.toString()
                findViewById<TextView>(R.id.tvDocumentoUri).text = "Arquivo: $nome"
            }
        }
    }

    // Launcher para pedir permissão
    private val pedirPermissao = registerForActivityResult(
        ActivityResultContracts.RequestMultiplePermissions()
    ) { permissions ->
        val concedida = permissions.values.any { it }
        if (concedida) {
            abrirSeletorArquivo()
        } else {
            Toast.makeText(
                this,
                "Permissão negada. Não é possível acessar arquivos.",
                Toast.LENGTH_SHORT
            ).show()
        }
    }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_cadastro_convenio)

        dbHelper = DatabaseHelper(this)
        convenioId = intent.getLongExtra("CONVENIO_ID", -1)

        val toolbar = findViewById<Toolbar>(R.id.toolbar)
        setSupportActionBar(toolbar)
        toolbar.setNavigationOnClickListener { finish() }

        // Spinner de status
        val spinner = findViewById<Spinner>(R.id.spinnerStatus)
        val statusList = listOf("Ativo", "Inativo", "Pendente", "Em Análise")
        val spinnerAdapter = ArrayAdapter(
            this, android.R.layout.simple_spinner_item, statusList
        )
        spinnerAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item)
        spinner.adapter = spinnerAdapter

        // Máscara de data nos dois campos
        aplicarMascaraData(findViewById(R.id.etDataInicio))
        aplicarMascaraData(findViewById(R.id.etDataVencimento))

        if (convenioId != -1L) {
            toolbar.title = "Editar Convênio"
            carregarDados(convenioId)
        }

        findViewById<Button>(R.id.btnSelecionarDoc).setOnClickListener {
            verificarPermissaoEAbrir()
        }

        findViewById<Button>(R.id.btnSalvar).setOnClickListener {
            salvarConvenio()
        }
    }

    // Máscara DD/MM/AAAA
    private fun aplicarMascaraData(campo: TextInputEditText) {
        campo.addTextChangedListener(object : TextWatcher {
            private var editando = false
            private var deletando = false

            override fun beforeTextChanged(s: CharSequence?, start: Int, count: Int, after: Int) {
                deletando = after < count
            }

            override fun onTextChanged(s: CharSequence?, start: Int, before: Int, count: Int) {}

            override fun afterTextChanged(s: Editable?) {
                if (editando || s == null) return
                editando = true

                // Remove tudo que não for número
                val digits = s.toString().replace("[^0-9]".toRegex(), "")

                val formatado = StringBuilder()
                for (i in digits.indices) {
                    if (i == 2 || i == 4) formatado.append("/")
                    if (i >= 8) break
                    formatado.append(digits[i])
                }

                campo.setText(formatado)
                campo.setSelection(formatado.length)

                editando = false
            }
        })
    }

    private fun verificarPermissaoEAbrir() {
        when {
            // Android 13+ (API 33+)
            Build.VERSION.SDK_INT >= Build.VERSION_CODES.TIRAMISU -> {
                val permissoes = arrayOf(
                    Manifest.permission.READ_MEDIA_IMAGES
                )
                val todas = permissoes.all {
                    ContextCompat.checkSelfPermission(this, it) ==
                            PackageManager.PERMISSION_GRANTED
                }
                if (todas) abrirSeletorArquivo()
                else pedirPermissao.launch(permissoes)
            }
            // Android 10–12 (API 29–32)
            Build.VERSION.SDK_INT >= Build.VERSION_CODES.Q -> {
                abrirSeletorArquivo()
            }
            // Android 7–9 (API 24–28)
            else -> {
                val permissao = Manifest.permission.READ_EXTERNAL_STORAGE
                if (ContextCompat.checkSelfPermission(this, permissao) ==
                    PackageManager.PERMISSION_GRANTED
                ) {
                    abrirSeletorArquivo()
                } else {
                    pedirPermissao.launch(arrayOf(permissao))
                }
            }
        }
    }

    private fun abrirSeletorArquivo() {
        val intent = Intent(Intent.ACTION_GET_CONTENT).apply {
            type = "*/*"
            putExtra(
                Intent.EXTRA_MIME_TYPES,
                arrayOf("application/pdf", "image/jpeg", "image/png")
            )
            addCategory(Intent.CATEGORY_OPENABLE)
            putExtra(Intent.EXTRA_LOCAL_ONLY, true)
        }
        selecionarArquivo.launch(Intent.createChooser(intent, "Selecionar documento"))
    }

    private fun carregarDados(id: Long) {
        val convenio = dbHelper.buscarPorId(id) ?: return
        findViewById<TextInputEditText>(R.id.etNomePlano).setText(convenio.nomePlano)
        findViewById<TextInputEditText>(R.id.etOperadora).setText(convenio.operadora)
        findViewById<TextInputEditText>(R.id.etNumeroCarteirinha).setText(convenio.numeroCarteirinha)
        findViewById<TextInputEditText>(R.id.etTipoPlano).setText(convenio.tipoPlano)
        findViewById<TextInputEditText>(R.id.etTitular).setText(convenio.titular)
        findViewById<TextInputEditText>(R.id.etDataInicio).setText(convenio.dataInicio)
        findViewById<TextInputEditText>(R.id.etDataVencimento).setText(convenio.dataVencimento)
        findViewById<TextInputEditText>(R.id.etObservacoes).setText(convenio.observacoes)

        val spinner = findViewById<Spinner>(R.id.spinnerStatus)
        val statusList = listOf("Ativo", "Inativo", "Pendente", "Em Análise")
        val index = statusList.indexOf(convenio.status)
        if (index >= 0) spinner.setSelection(index)

        if (convenio.documentoUri.isNotEmpty()) {
            documentoUri = convenio.documentoUri
            val nome = Uri.parse(documentoUri).lastPathSegment ?: documentoUri
            findViewById<TextView>(R.id.tvDocumentoUri).text = "Arquivo: $nome"
        }
    }

    private fun salvarConvenio() {
        val nomePlano = findViewById<TextInputEditText>(R.id.etNomePlano).text.toString().trim()
        val operadora = findViewById<TextInputEditText>(R.id.etOperadora).text.toString().trim()
        val carteirinha = findViewById<TextInputEditText>(R.id.etNumeroCarteirinha).text.toString().trim()
        val tipo = findViewById<TextInputEditText>(R.id.etTipoPlano).text.toString().trim()
        val titular = findViewById<TextInputEditText>(R.id.etTitular).text.toString().trim()
        val dataInicio = findViewById<TextInputEditText>(R.id.etDataInicio).text.toString().trim()
        val dataVenc = findViewById<TextInputEditText>(R.id.etDataVencimento).text.toString().trim()
        val status = findViewById<Spinner>(R.id.spinnerStatus).selectedItem.toString()
        val obs = findViewById<TextInputEditText>(R.id.etObservacoes).text.toString().trim()

        var valido = true

        if (nomePlano.isEmpty()) {
            findViewById<TextInputLayout>(R.id.tilNomePlano).error = "Campo obrigatório"
            valido = false
        } else {
            findViewById<TextInputLayout>(R.id.tilNomePlano).error = null
        }

        if (operadora.isEmpty()) {
            findViewById<TextInputLayout>(R.id.tilOperadora).error = "Campo obrigatório"
            valido = false
        } else {
            findViewById<TextInputLayout>(R.id.tilOperadora).error = null
        }

        if (carteirinha.isEmpty()) {
            findViewById<TextInputLayout>(R.id.tilNumeroCarteirinha).error = "Campo obrigatório"
            valido = false
        } else {
            findViewById<TextInputLayout>(R.id.tilNumeroCarteirinha).error = null
        }

        if (titular.isEmpty()) {
            findViewById<TextInputLayout>(R.id.tilTitular).error = "Campo obrigatório"
            valido = false
        } else {
            findViewById<TextInputLayout>(R.id.tilTitular).error = null
        }

        if (!valido) return

        val convenio = Convenio(
            id = if (convenioId != -1L) convenioId else 0,
            nomePlano = nomePlano,
            operadora = operadora,
            numeroCarteirinha = carteirinha,
            tipoPlano = tipo,
            titular = titular,
            dataInicio = dataInicio,
            dataVencimento = dataVenc,
            status = status,
            documentoUri = documentoUri,
            observacoes = obs
        )

        if (convenioId != -1L) {
            dbHelper.atualizarConvenio(convenio)
            Toast.makeText(this, "Convênio atualizado!", Toast.LENGTH_SHORT).show()
        } else {
            dbHelper.inserirConvenio(convenio)
            Toast.makeText(this, "Convênio salvo!", Toast.LENGTH_SHORT).show()
        }

        finish()
    }
}