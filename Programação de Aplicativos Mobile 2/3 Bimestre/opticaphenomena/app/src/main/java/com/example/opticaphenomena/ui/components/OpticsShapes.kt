package com.example.opticaphenomena.ui.components

import androidx.compose.foundation.Canvas
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.ui.Modifier
import androidx.compose.ui.geometry.Offset
import androidx.compose.ui.graphics.Brush
import androidx.compose.ui.graphics.Path
import androidx.compose.ui.graphics.drawscope.Stroke
import com.example.opticaphenomena.ui.theme.LightBlue
import com.example.opticaphenomena.ui.theme.LightCyan
import com.example.opticaphenomena.ui.theme.LightViolet
import com.example.opticaphenomena.ui.theme.SpectrumGradient
import kotlin.math.cos
import kotlin.math.sin

/**
 * Desenha um prisma triangular com um feixe branco entrando
 * e um leque de cores (espectro) saindo do outro lado.
 */
@androidx.compose.runtime.Composable
fun PrismIllustration(modifier: Modifier = Modifier) {
    Canvas(modifier = modifier.fillMaxSize()) {
        val w = size.width
        val h = size.height

        // Feixe de luz branca entrando
        drawLine(
            color = androidx.compose.ui.graphics.Color.White,
            start = Offset(0f, h * 0.5f),
            end = Offset(w * 0.38f, h * 0.55f),
            strokeWidth = 6f
        )

        // Triângulo do prisma
        val prism = Path().apply {
            moveTo(w * 0.38f, h * 0.85f)
            lineTo(w * 0.58f, h * 0.15f)
            lineTo(w * 0.62f, h * 0.85f)
            close()
        }
        drawPath(
            path = prism,
            brush = Brush.verticalGradient(listOf(LightCyan.copy(alpha = 0.35f), LightViolet.copy(alpha = 0.35f)))
        )
        drawPath(path = prism, color = androidx.compose.ui.graphics.Color.White, style = Stroke(width = 3f))

        // Leque de cores saindo
        SpectrumGradient.forEachIndexed { index, color ->
            val angle = -20f + index * 8f
            val radians = Math.toRadians(angle.toDouble())
            val endX = w * 0.62f + (w * 0.35f) * cos(radians).toFloat()
            val endY = h * 0.5f + (w * 0.35f) * sin(radians).toFloat()
            drawLine(
                color = color,
                start = Offset(w * 0.6f, h * 0.5f),
                end = Offset(endX, endY),
                strokeWidth = 5f
            )
        }
    }
}

/**
 * Desenha um padrão de franjas de difração (linhas paralelas
 * que variam em intensidade, como em uma rede de difração).
 */
@androidx.compose.runtime.Composable
fun DiffractionIllustration(modifier: Modifier = Modifier) {
    Canvas(modifier = modifier.fillMaxSize()) {
        val w = size.width
        val h = size.height
        val bars = 14

        for (i in 0 until bars) {
            val x = (w / bars) * i + (w / bars) / 2f
            val intensity = (sin(i * 0.6) + 1) / 2 // 0..1
            val barHeight = (h * 0.85f * intensity).toFloat().coerceAtLeast(h * 0.1f)
            val color = SpectrumGradient[i % SpectrumGradient.size]
            drawLine(
                color = color.copy(alpha = 0.55f + 0.45f * intensity.toFloat()),
                start = Offset(x, h),
                end = Offset(x, h - barHeight),
                strokeWidth = (w / bars) * 0.5f
            )
        }
    }
}

/**
 * Desenha arcos concêntricos coloridos representando um arco-íris.
 */
@androidx.compose.runtime.Composable
fun RainbowIllustration(modifier: Modifier = Modifier) {
    Canvas(modifier = modifier.fillMaxSize()) {
        val w = size.width
        val h = size.height
        val center = Offset(w / 2f, h * 1.05f)
        val baseRadius = h * 0.95f

        SpectrumGradient.forEachIndexed { index, color ->
            val radius = baseRadius - index * (h * 0.09f)
            drawArc(
                color = color,
                startAngle = 180f,
                sweepAngle = 180f,
                useCenter = false,
                topLeft = Offset(center.x - radius, center.y - radius),
                size = androidx.compose.ui.geometry.Size(radius * 2f, radius * 2f),
                style = Stroke(width = h * 0.07f)
            )
        }
    }
}

/**
 * Desenha um padrão espiralado em preto/branco/roxo,
 * clássico de ilusões de ótica (efeito hipnótico).
 */
@androidx.compose.runtime.Composable
fun IllusionIllustration(modifier: Modifier = Modifier) {
    Canvas(modifier = modifier.fillMaxSize()) {
        val w = size.width
        val h = size.height
        val center = Offset(w / 2f, h / 2f)
        val maxRadius = minOf(w, h) / 2f
        val rings = 10

        for (i in rings downTo 1) {
            val radius = maxRadius * (i / rings.toFloat())
            val color = if (i % 2 == 0) LightViolet.copy(alpha = 0.9f) else LightBlue.copy(alpha = 0.25f)
            drawCircle(color = color, radius = radius, center = center)
        }

        // linhas radiais para reforçar o efeito de movimento
        val lines = 12
        for (i in 0 until lines) {
            val angle = Math.toRadians((360.0 / lines) * i)
            val end = Offset(
                center.x + maxRadius * cos(angle).toFloat(),
                center.y + maxRadius * sin(angle).toFloat()
            )
            drawLine(
                color = androidx.compose.ui.graphics.Color.White.copy(alpha = 0.25f),
                start = center,
                end = end,
                strokeWidth = 2f
            )
        }
    }
}
