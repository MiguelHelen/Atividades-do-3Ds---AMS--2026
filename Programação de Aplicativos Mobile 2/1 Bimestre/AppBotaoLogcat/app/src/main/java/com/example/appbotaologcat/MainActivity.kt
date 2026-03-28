package com.example.appbotaologcat

import android.os.Bundle
import android.util.Log
import androidx.activity.ComponentActivity
import androidx.activity.compose.setContent
import androidx.compose.foundation.Image
import androidx.compose.foundation.background
import androidx.compose.foundation.layout.*
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.res.painterResource
import androidx.compose.ui.unit.dp

class MainActivity : ComponentActivity() {

    companion object {
        const val TAG = "NotasApp"
    }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContent {
            App()
        }
    }
}

@Composable
fun App() {

    var nome by remember { mutableStateOf("") }

    Column(
        modifier = Modifier
            .fillMaxSize()
            .background(Color(0xFFF5F5F5))
            .padding(20.dp),

        horizontalAlignment = Alignment.CenterHorizontally,
        verticalArrangement = Arrangement.SpaceEvenly
    ) {

        Text(
            text = "Miguel Heleno - 3DS-AMS",
            style = MaterialTheme.typography.headlineSmall,
            color = Color(0xFF7E57C2)
        )

        Image(
            painter = painterResource(id = R.drawable.logoo),
            contentDescription = "Logo",
            modifier = Modifier.size(140.dp)
        )

        OutlinedTextField(
            value = nome,
            onValueChange = { nome = it },
            label = { Text("Digite seu Nome") },
            modifier = Modifier.fillMaxWidth(),
            colors = OutlinedTextFieldDefaults.colors(
                focusedBorderColor = Color(0xFF7E57C2),
                focusedLabelColor = Color(0xFF7E57C2)
            )
        )

        NotaButton("Péssimo", nome, Color(0xFFE57373))
        NotaButton("Ruim", nome, Color(0xFFFFB74D))
        NotaButton("Bom", nome, Color(0xFF64B5F6))
        NotaButton("Excelente", nome, Color(0xFF7E57C2))
    }
}

@Composable
fun NotaButton(nota: String, nome: String, cor: Color) {

    Button(
        onClick = {

            if (nome.isNotEmpty()) {

                when (nota) {
                    "Péssimo" -> Log.e("NotasApp", "Cliente $nome avaliou o Restaurante como: Péssimo")
                    "Ruim" -> Log.w("NotasApp", "Cliente $nome avaliou o  Restaurante como: Ruim")
                    "Bom" -> Log.i("NotasApp", "Cliente $nome avaliou o Restaurante como: Bom")
                    "Excelente" -> Log.d("NotasApp", "Cliente $nome avaliou o Restaurante como: Excelente")
                }

            } else {
                Log.w("NotasApp", "Nome não informado!")
            }

        },
        colors = ButtonDefaults.buttonColors(containerColor = cor),
        modifier = Modifier
            .fillMaxWidth()
            .padding(5.dp)
    ) {
        Text(
            text = "Nota $nota",
            color = Color.White
        )
    }
}