package com.example.gestorconvenios

import android.content.Intent
import android.net.Uri
import android.os.Bundle
import android.view.View
import android.widget.Button
import android.widget.TextView
import android.widget.Toast
import androidx.appcompat.app.AlertDialog
import androidx.appcompat.app.AppCompatActivity
import androidx.appcompat.widget.Toolbar
import com.example.gestorconvenios.R

class DetalheConvenioActivity : AppCompatActivity() {

    private lateinit var dbHelper: DatabaseHelper
    private var convenioId: Long = -1

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_detalhe_convenio)

        dbHelper = DatabaseHelper(this)
        convenioId = intent.getLongExtra("CONVENIO_ID", -1)

        val toolbar = findViewById<Toolbar>(R.id.toolbar)
        setSupportActionBar(toolbar)
        toolbar.setNavigationOnClickListener { finish() }

        carregarDetalhe()

        findViewById<Button>(R.id.btnEditar).setOnClickListener {
            val intent = Intent(this, CadastroConvenioActivity::class.java)
            intent.putExtra("CONVENIO_ID", convenioId)
            startActivity(intent)
        }

        findViewById<Button>(R.id.btnExcluir).setOnClickListener {
            AlertDialog.Builder(this)
                .setTitle("Excluir Convênio")
                .setMessage("Tem certeza que deseja excluir este convênio?")
                .setPositiveButton("Sim") { _, _ ->
                    dbHelper.excluirConvenio(convenioId)
                    Toast.makeText(this, "Convênio excluído.", Toast.LENGTH_SHORT).show()
                    finish()
                }
                .setNegativeButton("Não", null)
                .show()
        }
    }

    override fun onResume() {
        super.onResume()
        carregarDetalhe()
    }

    private fun carregarDetalhe() {
        val convenio = dbHelper.buscarPorId(convenioId) ?: run {
            Toast.makeText(this, "Convênio não encontrado.", Toast.LENGTH_SHORT).show()
            finish()
            return
        }

        findViewById<TextView>(R.id.tvInicialDetalhe).text =
            convenio.nomePlano.firstOrNull()?.uppercase() ?: "?"
        findViewById<TextView>(R.id.tvNomePlanoDetalhe).text = convenio.nomePlano
        findViewById<TextView>(R.id.tvOperadoraDetalhe).text = convenio.operadora
        findViewById<TextView>(R.id.tvStatusDetalhe).text = convenio.status

        findViewById<TextView>(R.id.tvCarteirinha).text =
            "Carteirinha: ${convenio.numeroCarteirinha}"
        findViewById<TextView>(R.id.tvTipo).text =
            "Tipo: ${convenio.tipoPlano.ifEmpty { "Não informado" }}"
        findViewById<TextView>(R.id.tvTitular).text =
            "Titular: ${convenio.titular}"
        findViewById<TextView>(R.id.tvDataInicio).text =
            "Início: ${convenio.dataInicio.ifEmpty { "Não informado" }}"
        findViewById<TextView>(R.id.tvDataVencimento).text =
            "Vencimento: ${convenio.dataVencimento.ifEmpty { "Não informado" }}"
        findViewById<TextView>(R.id.tvObservacoes).text =
            convenio.observacoes.ifEmpty { "Sem observações" }

        val btnAbrirDoc = findViewById<Button>(R.id.btnAbrirDoc)
        val tvDocUri = findViewById<TextView>(R.id.tvDocUri)

        if (convenio.documentoUri.isNotEmpty()) {
            val uri = Uri.parse(convenio.documentoUri)
            val nomeArquivo = uri.lastPathSegment ?: convenio.documentoUri
            tvDocUri.text = "📎 $nomeArquivo\n\n🔗 URI: ${convenio.documentoUri}"
            tvDocUri.setTextColor(getColor(R.color.text_primary))
            btnAbrirDoc.visibility = View.VISIBLE

            btnAbrirDoc.setOnClickListener {
                try {
                    val intent = Intent(Intent.ACTION_VIEW).apply {
                        setDataAndType(uri, contentResolver.getType(uri) ?: "*/*")
                        addFlags(Intent.FLAG_GRANT_READ_URI_PERMISSION)
                    }
                    startActivity(intent)
                } catch (e: Exception) {
                    Toast.makeText(
                        this,
                        "Não foi possível abrir o documento.",
                        Toast.LENGTH_SHORT
                    ).show()
                }
            }
        } else {
            tvDocUri.text = "Nenhum documento vinculado"
            btnAbrirDoc.visibility = View.GONE
        }
    }
}