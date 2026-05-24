package com.example.gestorconvenios

import android.content.Intent
import android.os.Bundle
import androidx.appcompat.app.AppCompatActivity
import androidx.cardview.widget.CardView
import com.google.android.material.floatingactionbutton.FloatingActionButton
import com.example.gestorconvenios.R

class MainActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)

        findViewById<CardView>(R.id.cardLista).setOnClickListener {
            startActivity(Intent(this, ListaConveniosActivity::class.java))
        }

        findViewById<CardView>(R.id.cardNovo).setOnClickListener {
            startActivity(Intent(this, CadastroConvenioActivity::class.java))
        }

        findViewById<FloatingActionButton>(R.id.fab).setOnClickListener {
            startActivity(Intent(this, CadastroConvenioActivity::class.java))
        }

        findViewById<CardView>(R.id.cardSobre).setOnClickListener {
            android.widget.Toast.makeText(
                this,
                "Gestor Convênios v1.0 — Projeto Acadêmico",
                android.widget.Toast.LENGTH_SHORT
            ).show()
        }
    }
}