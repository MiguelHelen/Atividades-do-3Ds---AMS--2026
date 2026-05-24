package com.example.gestorconvenios

import android.app.Activity
import android.content.Intent
import android.net.Uri
import android.os.Bundle
import android.widget.*
import androidx.appcompat.app.AppCompatActivity
import androidx.appcompat.widget.Toolbar
import com.google.android.material.textfield.TextInputEditText
import com.google.android.material.textfield.TextInputLayout
import com.example.gestorconvenios.R

class CadastroConvenioActivity : AppCompatActivity() {

    private lateinit var dbHelper: DatabaseHelper
    private var documentoUri: String = ""
    private var convenioId: Long = -1
    private val PICK_FILE_REQUEST = 100

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_cadastro_convenio)

        dbHelper = DatabaseHelper(this)
        convenioId = intent.getLongExtra("CONVENIO_ID", -1)

        val toolbar = findViewById<Toolbar>(R.id.toolbar)
        setSupportActionBar(toolbar)
        toolbar.setNavigationOnClickListener { finish() }

        val spinner = findViewById<Spinner>(R.id.spinnerStatus)
        val statusList = listOf("Ativo", "Inativo", "Pendente", "Em Análise")
        val spinnerAdapter = ArrayAdapter(
            this,
            android.R.layout.simple_spinner_item,
            statusList
        )
        spinnerAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item)
        spinner.adapter = spinnerAdapter

        if (convenioId != -1L) {
            toolbar.title = "Editar Convênio"
            carregarDados(convenioId)
        }

        findViewById<Button>(R.id.btnSelecionarDoc).setOnClickListener {
            val intent = Intent(Intent.ACTION_OPEN_DOCUMENT).apply {
                addCategory(Intent.CATEGORY_OPENABLE)
                type = "*/*"
                putExtra(
                    Intent.EXTRA_MIME_TYPES,
                    arrayOf("application/pdf", "image/*")
                )
            }
            startActivityForResult(intent, PICK_FILE_REQUEST)

        }

        findViewById<Button>(R.id.btnSalvar).setOnClickListener {
            salvarConvenio()
        }
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
            findViewById<TextView>(R.id.tvDocumentoUri).text = "📎 $nome"
        }
    }

    override fun onActivityResult(requestCode: Int, resultCode: Int, data: Intent?) {
        super.onActivityResult(requestCode, resultCode, data)
        if (requestCode == PICK_FILE_REQUEST && resultCode == Activity.RESULT_OK) {
            data?.data?.let { uri ->
                contentResolver.takePersistableUriPermission(
                    uri, Intent.FLAG_GRANT_READ_URI_PERMISSION
                )
                documentoUri = uri.toString()
                val nome = uri.lastPathSegment ?: uri.toString()
                findViewById<TextView>(R.id.tvDocumentoUri).text = "📎 $nome"
            }
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