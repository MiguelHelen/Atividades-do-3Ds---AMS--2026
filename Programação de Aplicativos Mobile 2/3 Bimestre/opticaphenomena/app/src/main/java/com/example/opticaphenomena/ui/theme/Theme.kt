package com.example.opticaphenomena.ui.theme

import androidx.compose.foundation.isSystemInDarkTheme
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.darkColorScheme
import androidx.compose.runtime.Composable

private val OpticaColorScheme = darkColorScheme(
    primary = LightViolet,
    onPrimary = TextPrimary,
    secondary = LightCyan,
    onSecondary = SpaceNavy,
    tertiary = LightOrange,
    background = SpaceNavy,
    onBackground = TextPrimary,
    surface = CardSurface,
    onSurface = TextPrimary,
    error = ErrorRed,
    onError = TextPrimary
)

@Composable
fun OpticaFenomenosTheme(
    darkTheme: Boolean = isSystemInDarkTheme(),
    content: @Composable () -> Unit
) {
    MaterialTheme(
        colorScheme = OpticaColorScheme,
        typography = Typography,
        content = content
    )
}
