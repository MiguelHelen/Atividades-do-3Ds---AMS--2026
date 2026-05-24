package com.example.gestorconvenios

data class Convenio(
    val id: Long = 0,
    val nomePlano: String,
    val operadora: String,
    val numeroCarteirinha: String,
    val tipoPlano: String,
    val titular: String,
    val dataInicio: String,
    val dataVencimento: String,
    val status: String,
    val documentoUri: String = "",
    val observacoes: String = ""
)