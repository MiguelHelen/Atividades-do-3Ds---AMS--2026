package com.example.opticaphenomena.pages

import androidx.compose.foundation.background
import androidx.compose.foundation.layout.Arrangement
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.PaddingValues
import androidx.compose.foundation.layout.Row
import androidx.compose.foundation.layout.aspectRatio
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.fillMaxWidth
import androidx.compose.foundation.layout.padding
import androidx.compose.foundation.lazy.grid.GridCells
import androidx.compose.foundation.lazy.grid.LazyVerticalGrid
import androidx.compose.foundation.lazy.grid.items
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material3.Card
import androidx.compose.material3.CardDefaults
import androidx.compose.material3.Icon
import androidx.compose.material3.IconButton
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.Text
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.ExitToApp
import androidx.compose.runtime.Composable
import androidx.compose.runtime.LaunchedEffect
import androidx.compose.runtime.livedata.observeAsState
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Brush
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import androidx.navigation.NavController
import com.example.opticaphenomena.AuthState
import com.example.opticaphenomena.AuthViewModel
import com.example.opticaphenomena.ui.components.DiffractionIllustration
import com.example.opticaphenomena.ui.components.IllusionIllustration
import com.example.opticaphenomena.ui.components.PrismIllustration
import com.example.opticaphenomena.ui.components.RainbowIllustration
import com.example.opticaphenomena.ui.theme.CardSurface
import com.example.opticaphenomena.ui.theme.SpaceNavy
import com.example.opticaphenomena.ui.theme.SpaceNavyLight
import com.example.opticaphenomena.ui.theme.TextSecondary

private data class OpticPhenomenon(
    val title: String,
    val description: String,
    val illustration: @Composable (Modifier) -> Unit
)

private val phenomena = listOf(
    OpticPhenomenon(
        title = "Prisma",
        description = "A luz branca se separa em cores ao atravessar um prisma, devido à refração.",
        illustration = { m -> PrismIllustration(m) }
    ),
    OpticPhenomenon(
        title = "Difração",
        description = "Ondas de luz se espalham e formam franjas ao passar por fendas estreitas.",
        illustration = { m -> DiffractionIllustration(m) }
    ),
    OpticPhenomenon(
        title = "Arco-íris",
        description = "Gotas de água refratam e refletem a luz solar, formando o arco de cores.",
        illustration = { m -> RainbowIllustration(m) }
    ),
    OpticPhenomenon(
        title = "Ilusão de Óptica",
        description = "Padrões que enganam o cérebro, criando sensação de movimento ou profundidade.",
        illustration = { m -> IllusionIllustration(m) }
    )
)

@Composable
fun HomePage(modifier: Modifier = Modifier, navController: NavController, authViewModel: AuthViewModel) {

    val authState = authViewModel.authState.observeAsState()

    LaunchedEffect(authState.value) {
        when (authState.value) {
            is AuthState.Unauthenticated -> navController.navigate("login")
            else -> Unit
        }
    }

    Column(
        modifier = modifier
            .fillMaxSize()
            .background(Brush.verticalGradient(listOf(SpaceNavy, SpaceNavyLight)))
    ) {
        Row(
            modifier = Modifier
                .fillMaxWidth()
                .padding(20.dp),
            horizontalArrangement = Arrangement.SpaceBetween,
            verticalAlignment = Alignment.CenterVertically
        ) {
            Column {
                Text(
                    text = "Galeria da Luz",
                    style = MaterialTheme.typography.headlineLarge,
                    fontWeight = FontWeight.Bold
                )
                Text(
                    text = "Óptica e Fenômenos Luminosos",
                    style = MaterialTheme.typography.bodyMedium,
                    color = TextSecondary
                )
            }
            IconButton(onClick = { authViewModel.signout() }) {
                Icon(imageVector = Icons.Filled.ExitToApp, contentDescription = "Sair")
            }
        }

        LazyVerticalGrid(
            columns = GridCells.Fixed(2),
            contentPadding = PaddingValues(16.dp),
            horizontalArrangement = Arrangement.spacedBy(16.dp),
            verticalArrangement = Arrangement.spacedBy(16.dp),
            modifier = Modifier.fillMaxSize()
        ) {
            items(phenomena) { phenomenon ->
                PhenomenonCard(phenomenon)
            }
        }
    }
}

@Composable
private fun PhenomenonCard(phenomenon: OpticPhenomenon) {
    Card(
        shape = RoundedCornerShape(20.dp),
        colors = CardDefaults.cardColors(containerColor = CardSurface),
        modifier = Modifier.fillMaxWidth()
    ) {
        Column(modifier = Modifier.padding(12.dp)) {
            phenomenon.illustration(
                Modifier
                    .fillMaxWidth()
                    .aspectRatio(1.2f)
            )
            Text(
                text = phenomenon.title,
                style = MaterialTheme.typography.titleMedium,
                fontWeight = FontWeight.Bold,
                modifier = Modifier.padding(top = 10.dp)
            )
            Text(
                text = phenomenon.description,
                style = MaterialTheme.typography.bodyMedium,
                color = TextSecondary,
                modifier = Modifier.padding(top = 4.dp)
            )
        }
    }
}
