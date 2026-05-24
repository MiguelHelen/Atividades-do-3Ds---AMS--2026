package com.example.gestorconvenios

import android.graphics.Color
import android.graphics.drawable.GradientDrawable
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.example.gestorconvenios.R

class ConvenioAdapter(
    private var lista: List<Convenio>,
    private val onClick: (Convenio) -> Unit
) : RecyclerView.Adapter<ConvenioAdapter.ViewHolder>() {

    inner class ViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        val tvInicial: TextView = view.findViewById(R.id.tvInicial)
        val tvNomePlano: TextView = view.findViewById(R.id.tvNomePlano)
        val tvOperadora: TextView = view.findViewById(R.id.tvOperadora)
        val tvVencimento: TextView = view.findViewById(R.id.tvVencimento)
        val tvStatus: TextView = view.findViewById(R.id.tvStatus)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.item_convenio, parent, false)
        return ViewHolder(view)
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        val convenio = lista[position]

        holder.tvInicial.text = convenio.nomePlano.firstOrNull()?.uppercase() ?: "?"
        holder.tvNomePlano.text = convenio.nomePlano
        holder.tvOperadora.text = convenio.operadora

        if (convenio.dataVencimento.isNotEmpty()) {
            holder.tvVencimento.text = "Vence: ${convenio.dataVencimento}"
            holder.tvVencimento.visibility = View.VISIBLE
        } else {
            holder.tvVencimento.visibility = View.GONE
        }

        holder.tvStatus.text = convenio.status
        val (bgColor, txtColor) = when (convenio.status) {
            "Ativo"      -> Pair("#E8F5E9", "#2E7D32")
            "Inativo"    -> Pair("#FFEBEE", "#C62828")
            "Pendente"   -> Pair("#FFF8E1", "#F57F17")
            else         -> Pair("#E3F2FD", "#1565C0")
        }

        val drawable = GradientDrawable()
        drawable.setColor(Color.parseColor(bgColor))
        drawable.cornerRadius = 20f
        holder.tvStatus.background = drawable
        holder.tvStatus.setTextColor(Color.parseColor(txtColor))
        holder.tvStatus.setPadding(16, 6, 16, 6)

        holder.itemView.setOnClickListener { onClick(convenio) }
    }

    override fun getItemCount() = lista.size

    fun atualizarLista(novaLista: List<Convenio>) {
        lista = novaLista
        notifyDataSetChanged()
    }
}