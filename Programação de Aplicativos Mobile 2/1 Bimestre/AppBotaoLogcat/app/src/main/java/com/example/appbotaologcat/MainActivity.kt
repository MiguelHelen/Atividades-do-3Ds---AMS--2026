package com.example.appbotaologcat

import android.os.Bundle
import android.util.Log
import androidx.activity.ComponentActivity
import androidx.activity.compose.setContent
import androidx.compose.foundation.layout.*
import androidx.compose.material3.*
import androidx.compose.runtime.Composable
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.unit.dp

class MainActivity : ComponentActivity() {

    companion object {
        const val TAG = "TestAndroid"
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

    Column(
        modifier = Modifier
            .fillMaxSize()
            .padding(20.dp),

        verticalArrangement = Arrangement.SpaceEvenly,
        horizontalAlignment = Alignment.CenterHorizontally
    ) {

        Button(
            onClick = {
                Log.d("TestAndroid", "App: Clicou em DEBUG!")
            },
            colors = ButtonDefaults.buttonColors(containerColor = Color(0xFF388E3C)),
            modifier = Modifier.fillMaxWidth()
        ) {
            Text("DEBUG")
        }

        Button(
            onClick = {
                Log.i("TestAndroid", "App: Clicou em INFO!")
            },
            colors = ButtonDefaults.buttonColors(containerColor = Color(0xFF1A237E)),
            modifier = Modifier.fillMaxWidth()
        ) {
            Text("INFO")
        }

        Button(
            onClick = {
                Log.w("TestAndroid", "App: Clicou em WARNING!")
            },
            colors = ButtonDefaults.buttonColors(containerColor = Color(0xFFFF6F00)),
            modifier = Modifier.fillMaxWidth()
        ) {
            Text("WARNING")
        }

        Button(
            onClick = {
                try {
                    throw RuntimeException("Clicou em Error!")
                } catch (ex: Exception) {
                    Log.e("TestAndroid", "App: ${ex.message}")
                }
            },
            colors = ButtonDefaults.buttonColors(containerColor = Color(0xFFB71C1C)),
            modifier = Modifier.fillMaxWidth()
        ) {
            Text("ERROR")
        }
    }
}