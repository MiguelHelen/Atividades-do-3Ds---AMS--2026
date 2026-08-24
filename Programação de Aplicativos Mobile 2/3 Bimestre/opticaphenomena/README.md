#  Óptica e Fenômenos Luminosos

Aplicativo Android desenvolvido em **Kotlin + Jetpack Compose**, com autenticação de usuários via **Firebase Authentication (Email/Senha)**.

## 🎯 Tema escolhido

**Óptica e Fenômenos Luminosos** — uma galeria visual que apresenta quatro fenômenos da luz:

- **Prisma** — dispersão da luz branca em cores, por refração.
- **Difração de luz** — padrão de franjas formado quando a luz passa por fendas estreitas.
- **Arco-íris** — arcos coloridos formados pela refração/reflexão da luz em gotas de água.
- **Ilusões de óptica** — padrões visuais que enganam a percepção do cérebro.

Cada fenômeno é ilustrado com desenhos vetoriais próprios (feitos com `Canvas` do Compose, sem depender de imagens externas), usando uma paleta de cores inspirada no espectro visível sobre um fundo "espaço escuro", para dar identidade visual ao app.

##  Funcionalidades

- Cadastro de usuário (Email/Senha) via Firebase Authentication.
- Login de usuário existente.
- Tela protegida (Home) só acessível após autenticação.
- Logout.
- Redirecionamento automático conforme o estado de autenticação (`AuthState`).

##  Arquitetura

```
app/src/main/java/com/example/opticaphenomena/
├── MainActivity.kt          -> ponto de entrada, monta o NavHost
├── AuthViewModel.kt         -> lógica de login/cadastro/logout com Firebase Auth
├── MyAppNavigation.kt       -> rotas de navegação (login, signup, home)
├── pages/
│   ├── LoginPage.kt
│   ├── SignupPage.kt
│   └── HomePage.kt          -> galeria dos fenômenos ópticos
├── ui/theme/
│   ├── Color.kt
│   ├── Type.kt
│   └── Theme.kt
└── ui/components/
    └── OpticsShapes.kt      -> ilustrações (prisma, difração, arco-íris, ilusão)
```

Padrão usado: **MVVM simples**, com `AuthViewModel` expondo um `LiveData<AuthState>` observado pelas telas via `observeAsState()`.

---

## ▶️ Como rodar o projeto (passo a passo)

### 1. Criar o projeto no Android Studio
1. Abra o Android Studio → **New Project** → **Empty Activity (Compose)**.
2. Nome: `OpticaFenomenos` (ou o que preferir).
3. Package name: `com.example.opticaphenomena` (se usar outro nome, ajuste o `package` na primeira linha de cada arquivo `.kt` deste projeto).
4. Linguagem: **Kotlin**. Minimum SDK: 24+.

### 2. Conectar o Firebase 
1. No Android Studio, vá em **Tools → Firebase**.
2. Na aba **Authentication**, clique em **Authenticate using Email/Password** (ou similar) → **Connect to Firebase** e escolha "Criar um projeto do Firebase" (ex: `OpticaFenomenosApp`).
3. Depois clique em **Add the Firebase Authentication SDK to your app** e aceite as mudanças (isso adiciona automaticamente `google-services.json`, o plugin do Google Services e as dependências do `firebase-auth` no `build.gradle`).
4. No **Console do Firebase** (console.firebase.google.com), abra o projeto → **Authentication → Método de login → Email/senha → Ativar → Salvar**.

### 3. Adicionar a dependência de navegação
O assistente do Firebase não adiciona o Navigation Compose. No arquivo `app/build.gradle.kts`, dentro do bloco `dependencies { }`, adicione:

```kotlin
implementation("androidx.navigation:navigation-compose:2.8.0")
implementation("androidx.lifecycle:lifecycle-livedata-ktx:2.8.4")
implementation("androidx.compose.material:material-icons-core")
```

(Se o Android Studio já tiver adicionado `firebase-auth`, `androidx.credentials` etc. via assistente, pode manter — não atrapalha.)

Clique em **Sync Now**.

### 4. Copiar os arquivos deste projeto
Copie todos os arquivos da pasta `app/src/main/java/com/example/opticaphenomena/` deste pacote para dentro do seu projeto, substituindo o pacote gerado pelo wizard (apague o `MainActivity.kt` padrão e cole os arquivos daqui).

> ⚠️ Se você usar um `package name` diferente de `com.example.opticaphenomena`, troque a primeira linha `package ...` em **todos** os arquivos `.kt` para o nome do seu pacote.

### 5. Rodar
Rode o app em um emulador ou celular físico. Crie uma conta na tela de cadastro, faça login e veja a galeria.


---

## 🛠️ Tecnologias
- Kotlin
- Jetpack Compose (Material 3)
- Firebase Authentication
- Navigation Compose
- Arquitetura MVVM (ViewModel + LiveData)
