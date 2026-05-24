package com.example.gestorconvenios

import android.content.Intent
import android.os.Bundle
import android.text.Editable
import android.text.TextWatcher
import android.view.View
import android.widget.EditText
import android.widget.LinearLayout
import androidx.appcompat.app.AppCompatActivity
import androidx.appcompat.widget.Toolbar
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.google.android.material.floatingactionbutton.FloatingActionButton
import com.example.gestorconvenios.R

class ListaConveniosActivity : AppCompatActivity() {

    private lateinit var dbHelper: DatabaseHelper
    private lateinit var adapter: ConvenioAdapter
    private lateinit var recyclerView: RecyclerView
    private lateinit var layoutVazio: LinearLayout

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_lista_convenios)

        val toolbar = findViewById<Toolbar>(R.id.toolbar)
        setSupportActionBar(toolbar)
        toolbar.setNavigationOnClickListener { finish() }

        dbHelper = DatabaseHelper(this)
        recyclerView = findViewById(R.id.recyclerView)
        layoutVazio = findViewById(R.id.layoutVazio)

        recyclerView.layoutManager = LinearLayoutManager(this)
        adapter = ConvenioAdapter(emptyList()) { convenio ->
            val intent = Intent(this, DetalheConvenioActivity::class.java)
            intent.putExtra("CONVENIO_ID", convenio.id)
            startActivity(intent)
        }
        recyclerView.adapter = adapter

        findViewById<EditText>(R.id.etBusca).addTextChangedListener(object : TextWatcher {
            override fun afterTextChanged(s: Editable?) {
                val texto = s.toString().trim()
                val lista = if (texto.isEmpty()) dbHelper.buscarTodos()
                else dbHelper.buscarPorTexto(texto)
                adapter.atualizarLista(lista)
                mostrarEstadoVazio(lista.isEmpty())
            }
            override fun beforeTextChanged(s: CharSequence?, start: Int, count: Int, after: Int) {}
            override fun onTextChanged(s: CharSequence?, start: Int, before: Int, count: Int) {}
        })

        findViewById<FloatingActionButton>(R.id.fab).setOnClickListener {
            startActivity(Intent(this, CadastroConvenioActivity::class.java))
        }
    }

    override fun onResume() {
        super.onResume()
        val lista = dbHelper.buscarTodos()
        adapter.atualizarLista(lista)
        mostrarEstadoVazio(lista.isEmpty())
    }

    private fun mostrarEstadoVazio(vazio: Boolean) {
        layoutVazio.visibility = if (vazio) View.VISIBLE else View.GONE
        recyclerView.visibility = if (vazio) View.GONE else View.VISIBLE
    }
}