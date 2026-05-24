package com.example.gestorconvenios

import android.content.ContentValues
import android.content.Context
import android.database.Cursor
import android.database.sqlite.SQLiteDatabase
import android.database.sqlite.SQLiteOpenHelper

class DatabaseHelper(context: Context) : SQLiteOpenHelper(
    context, DATABASE_NAME, null, DATABASE_VERSION
) {
    companion object {
        private const val DATABASE_NAME = "gestorconvenios.db"
        private const val DATABASE_VERSION = 1

        const val TABLE_CONVENIOS = "convenios"
        const val COL_ID = "id"
        const val COL_NOME_PLANO = "nome_plano"
        const val COL_OPERADORA = "operadora"
        const val COL_NUMERO_CARTEIRINHA = "numero_carteirinha"
        const val COL_TIPO_PLANO = "tipo_plano"
        const val COL_TITULAR = "titular"
        const val COL_DATA_INICIO = "data_inicio"
        const val COL_DATA_VENCIMENTO = "data_vencimento"
        const val COL_STATUS = "status"
        const val COL_DOCUMENTO_URI = "documento_uri"
        const val COL_OBSERVACOES = "observacoes"
    }

    override fun onCreate(db: SQLiteDatabase) {
        val createTable = """
            CREATE TABLE $TABLE_CONVENIOS (
                $COL_ID INTEGER PRIMARY KEY AUTOINCREMENT,
                $COL_NOME_PLANO TEXT NOT NULL,
                $COL_OPERADORA TEXT NOT NULL,
                $COL_NUMERO_CARTEIRINHA TEXT NOT NULL,
                $COL_TIPO_PLANO TEXT,
                $COL_TITULAR TEXT NOT NULL,
                $COL_DATA_INICIO TEXT,
                $COL_DATA_VENCIMENTO TEXT,
                $COL_STATUS TEXT DEFAULT 'Ativo',
                $COL_DOCUMENTO_URI TEXT,
                $COL_OBSERVACOES TEXT
            )
        """.trimIndent()
        db.execSQL(createTable)
    }

    override fun onUpgrade(db: SQLiteDatabase, oldVersion: Int, newVersion: Int) {
        db.execSQL("DROP TABLE IF EXISTS $TABLE_CONVENIOS")
        onCreate(db)
    }

    fun inserirConvenio(convenio: Convenio): Long {
        val db = writableDatabase
        val values = ContentValues().apply {
            put(COL_NOME_PLANO, convenio.nomePlano)
            put(COL_OPERADORA, convenio.operadora)
            put(COL_NUMERO_CARTEIRINHA, convenio.numeroCarteirinha)
            put(COL_TIPO_PLANO, convenio.tipoPlano)
            put(COL_TITULAR, convenio.titular)
            put(COL_DATA_INICIO, convenio.dataInicio)
            put(COL_DATA_VENCIMENTO, convenio.dataVencimento)
            put(COL_STATUS, convenio.status)
            put(COL_DOCUMENTO_URI, convenio.documentoUri)
            put(COL_OBSERVACOES, convenio.observacoes)
        }
        val id = db.insert(TABLE_CONVENIOS, null, values)
        db.close()
        return id
    }

    fun buscarTodos(): List<Convenio> {
        val lista = mutableListOf<Convenio>()
        val db = readableDatabase
        val cursor = db.query(
            TABLE_CONVENIOS, null, null, null, null, null,
            "$COL_NOME_PLANO ASC"
        )
        if (cursor.moveToFirst()) {
            do {
                lista.add(cursorParaConvenio(cursor))
            } while (cursor.moveToNext())
        }
        cursor.close()
        db.close()
        return lista
    }

    fun buscarPorId(id: Long): Convenio? {
        val db = readableDatabase
        val cursor = db.query(
            TABLE_CONVENIOS, null,
            "$COL_ID = ?", arrayOf(id.toString()),
            null, null, null
        )
        val convenio = if (cursor.moveToFirst()) cursorParaConvenio(cursor) else null
        cursor.close()
        db.close()
        return convenio
    }

    fun buscarPorTexto(texto: String): List<Convenio> {
        val lista = mutableListOf<Convenio>()
        val db = readableDatabase
        val query = "%$texto%"
        val cursor = db.query(
            TABLE_CONVENIOS, null,
            "$COL_NOME_PLANO LIKE ? OR $COL_OPERADORA LIKE ? OR $COL_TITULAR LIKE ?",
            arrayOf(query, query, query),
            null, null, "$COL_NOME_PLANO ASC"
        )
        if (cursor.moveToFirst()) {
            do { lista.add(cursorParaConvenio(cursor)) } while (cursor.moveToNext())
        }
        cursor.close()
        db.close()
        return lista
    }

    fun atualizarConvenio(convenio: Convenio): Int {
        val db = writableDatabase
        val values = ContentValues().apply {
            put(COL_NOME_PLANO, convenio.nomePlano)
            put(COL_OPERADORA, convenio.operadora)
            put(COL_NUMERO_CARTEIRINHA, convenio.numeroCarteirinha)
            put(COL_TIPO_PLANO, convenio.tipoPlano)
            put(COL_TITULAR, convenio.titular)
            put(COL_DATA_INICIO, convenio.dataInicio)
            put(COL_DATA_VENCIMENTO, convenio.dataVencimento)
            put(COL_STATUS, convenio.status)
            put(COL_DOCUMENTO_URI, convenio.documentoUri)
            put(COL_OBSERVACOES, convenio.observacoes)
        }
        val linhas = db.update(
            TABLE_CONVENIOS, values,
            "$COL_ID = ?", arrayOf(convenio.id.toString())
        )
        db.close()
        return linhas
    }

    fun excluirConvenio(id: Long): Int {
        val db = writableDatabase
        val linhas = db.delete(
            TABLE_CONVENIOS,
            "$COL_ID = ?", arrayOf(id.toString())
        )
        db.close()
        return linhas
    }

    private fun cursorParaConvenio(cursor: Cursor): Convenio {
        return Convenio(
            id = cursor.getLong(cursor.getColumnIndexOrThrow(COL_ID)),
            nomePlano = cursor.getString(cursor.getColumnIndexOrThrow(COL_NOME_PLANO)),
            operadora = cursor.getString(cursor.getColumnIndexOrThrow(COL_OPERADORA)),
            numeroCarteirinha = cursor.getString(cursor.getColumnIndexOrThrow(COL_NUMERO_CARTEIRINHA)),
            tipoPlano = cursor.getString(cursor.getColumnIndexOrThrow(COL_TIPO_PLANO)) ?: "",
            titular = cursor.getString(cursor.getColumnIndexOrThrow(COL_TITULAR)),
            dataInicio = cursor.getString(cursor.getColumnIndexOrThrow(COL_DATA_INICIO)) ?: "",
            dataVencimento = cursor.getString(cursor.getColumnIndexOrThrow(COL_DATA_VENCIMENTO)) ?: "",
            status = cursor.getString(cursor.getColumnIndexOrThrow(COL_STATUS)) ?: "Ativo",
            documentoUri = cursor.getString(cursor.getColumnIndexOrThrow(COL_DOCUMENTO_URI)) ?: "",
            observacoes = cursor.getString(cursor.getColumnIndexOrThrow(COL_OBSERVACOES)) ?: ""
        )
    }
}