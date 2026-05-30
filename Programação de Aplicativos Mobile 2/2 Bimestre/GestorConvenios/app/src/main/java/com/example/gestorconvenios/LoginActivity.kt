package com.example.gestorconvenios

import android.content.Intent
import android.os.Bundle
import android.view.View
import android.widget.Button
import android.widget.TextView
import androidx.appcompat.app.AppCompatActivity
import com.google.android.material.textfield.TextInputEditText
import com.google.android.material.textfield.TextInputLayout

class LoginActivity : AppCompatActivity() {

    // Credenciais fixas do administrador
    private val USUARIO_ADMIN = "admin"
    private val SENHA_ADMIN = "1234"

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_login)

        configurarBotaoVoltar()

        val btnEntrar = findViewById<Button>(R.id.btnEntrar)
        val tvErro = findViewById<TextView>(R.id.tvErroLogin)
        val tilUsuario = findViewById<TextInputLayout>(R.id.tilUsuario)
        val tilSenha = findViewById<TextInputLayout>(R.id.tilSenha)

        btnEntrar.setOnClickListener {
            val usuario = findViewById<TextInputEditText>(R.id.etUsuario)
                .text.toString().trim()
            val senha = findViewById<TextInputEditText>(R.id.etSenha)
                .text.toString().trim()


            tilUsuario.error = null
            tilSenha.error = null
            tvErro.visibility = View.GONE


            var valido = true
            if (usuario.isEmpty()) {
                tilUsuario.error = "Informe o usuário"
                valido = false
            }
            if (senha.isEmpty()) {
                tilSenha.error = "Informe a senha"
                valido = false
            }
            if (!valido) return@setOnClickListener


            if (usuario == USUARIO_ADMIN && senha == SENHA_ADMIN) {
                // Login correto — vai para o menu principal
                startActivity(Intent(this, MainActivity::class.java))
                finish()
            } else {
                // Login incorreto — mostra erro
                tvErro.visibility = View.VISIBLE
                tilUsuario.error = " "
                tilSenha.error = " "
            }
        }
    }


    private fun configurarBotaoVoltar() {
        onBackPressedDispatcher.addCallback(
            this,
            object : androidx.activity.OnBackPressedCallback(true) {
                override fun handleOnBackPressed() {
                    finishAffinity()
                }
            }
        )
    }
}