# 🔓 SQL Injection Demo - Aplicación Educacional Completa

Aplicación web dinámica para aprender sobre vulnerabilidades de **inyección SQL** en un ambiente controlado y seguro. Incluye documentación completa sobre arquitectura MVC, ejemplo de ataques, y medidas de defensa.

---

## 📋 Tabla de Contenidos

1. [Características](#características)
2. [Requisitos](#requisitos)
3. [Instalación y Uso](#instalación-y-uso)
4. [Guía Rápida](#guía-rápida)
5. [Estructura del Proyecto](#estructura-del-proyecto)
6. [Usuarios de Prueba](#usuarios-de-prueba)
7. [Pruebas de SQL Injection](#pruebas-de-sql-injection)
8. [Arquitectura MVC](#arquitectura-mvc)
9. [Ejemplos de Ataques](#ejemplos-de-ataques)
10. [Medidas de Defensa](#medidas-de-defensa)
11. [Preguntas Frecuentes](#preguntas-frecuentes)

---

## ✨ Características

- ✅ Arquitectura MVC completa y profesional
- ✅ Interfaz moderna con TailwindCSS
- ✅ Formulario de login vulnerable a SQL injection (propósito educativo)
- ✅ Dashboard que muestra usuarios de la base de datos
- ✅ Base de datos SQLite (sin configuración)
- ✅ Sin dependencias externas (solo PHP 7.4+)
- ✅ Sin Docker, sin Node.js
- ✅ Documentación completa incluida
- ✅ Ejemplos de ataques y defensas

---

## 🛠️ Requisitos

- **PHP 7.4** o superior
- **Extensión PDO** con soporte para SQLite habilitada
- **Navegador moderno** (Chrome, Firefox, Safari, Edge)
- Windows, macOS o Linux

---

## 🚀 Instalación y Uso

### Paso 1: Abre Terminal

```bash
cd /home/silence/Documentos/Universidad/Ciberseguridad/Inyection
```

### Paso 2: Inicia el Servidor PHP

```bash
php -S localhost:8001 -t public
```

Verás:
```
[Día Mes Tiempo] Escuchando en http://localhost:8001
```

### Paso 3: Abre tu Navegador

Accede a:
```
http://localhost:8001
```

---

## ⚡ Guía Rápida

### ✅ Prueba 1: Login Normal (Control)

**Entrada válida:**
- Usuario: `admin`
- Contraseña: `admin123`
- **Resultado esperado:** ✅ Acceso permitido al dashboard

### ❌ Prueba 2: Credenciales Inválidas

**Entrada:**
- Usuario: `admin`
- Contraseña: `wrongpass`
- **Resultado esperado:** ❌ Acceso denegado

### 🚨 Prueba 3: SQL Injection - Bypass Básico

**Ingresa en el campo Usuario:**
```
' or '1'='1
```

**Ingresa en el campo Contraseña:**
```
anything
```

**¿Qué sucede?** El query se ejecuta así:
```sql
SELECT * FROM users WHERE username = '' or '1'='1' AND password = 'anything'
```

Como `'1'='1'` siempre es verdadero, el sistema retorna el primer usuario.

**Resultado esperado:** ✅ ¡Acceso permitido sin credenciales válidas!

### 🚨 Prueba 4: SQL Injection - Bypass con Comentario

**Usuario:** `' or '1'='1' --`
**Contraseña:** `cualquier cosa`

El `--` comenta el resto:
```sql
SELECT * FROM users WHERE username = '' or '1'='1' -- ' AND password = '...'
```

**Resultado esperado:** ✅ Acceso garantizado

### 🚨 Prueba 5: SQL Injection - Ambos campos

**Usuario:** `' or '1'='1`
**Contraseña:** `' or '1'='1`

Ambas condiciones son verdaderas, acceso permitido.

**Resultado esperado:** ✅ Acceso sin validación

---

## 📁 Estructura del Proyecto

```
Inyection/
├── app/
│   ├── Controllers/
│   │   ├── LoginController.php      ← Maneja login
│   │   └── DashboardController.php  ← Maneja dashboard
│   ├── Models/
│   │   ├── Database.php             ← Conexión BD
│   │   └── User.php                 ← AQUÍ está la vulnerabilidad
│   └── Views/
│       ├── login.php                ← Formulario HTML
│       └── dashboard.php            ← Panel de usuarios
├── database/
│   └── users.db                     ← Se crea automáticamente
├── public/
│   ├── index.php                    ← Router principal
│   ├── .htaccess                    ← Reescritura URLs
│   ├── js/
│   │   └── login.js                 ← JavaScript del cliente
│   └── css/                         ← CSS personalizado
└── README.md                        ← Este archivo
```

---

## 👥 Usuarios de Prueba

| Usuario | Contraseña | Email |
|---------|-----------|-------|
| admin | admin123 | admin@example.com |
| usuario1 | pass123 | usuario1@example.com |
| usuario2 | pass456 | usuario2@example.com |
| john | john2024 | john@example.com |

---

## 🧪 Pruebas Detalladas de SQL Injection

### Query Vulnerable
```php
// app/Models/User.php
public function loginVulnerable($username, $password) {
    $sql = "SELECT * FROM users WHERE username = '" . $username . "' AND password = '" . $password . "'";
    //                                              ^^^                              ^^^
    //                                    Concatenación directa - ¡VULNERABLE!
}
```

### Prueba Técnica

La entrada del usuario se concatena directamente en el SQL:

```sql
-- Usuario ingresa: ' or '1'='1
-- Password ingresa: anything

SELECT * FROM users WHERE username = '' or '1'='1' AND password = 'anything'
                                      ^^^^^^^^^^^
                                 Siempre verdadero!
                                 
-- El query retorna el primer usuario encontrado
```

### Análisis Técnico

**Problema:** Concatenación directa de entrada del usuario sin validación

```php
$sql = "SELECT * FROM users WHERE username = '" . $username . "' AND password = '" . $password . "'";
```

Si el usuario ingresa `' or '1'='1`, el SQL resultante es:
```sql
SELECT * FROM users WHERE username = '' or '1'='1' AND password = 'anything'
```

La condición `'' or '1'='1'` es **siempre verdadera**, permitiendo acceso sin credenciales válidas.

---

## 🏗️ Arquitectura MVC

### Visión General

```
request (usuario)
    ↓
public/index.php (Router)
    ↓
Controllers (Lógica de negocio)
    ↓
Models (Acceso a datos)
    ↓
Database (Operaciones SQL)
    ↓
Views (Presentación al usuario)
    ↓
response (HTML + CSS + JS)
```

### Componentes

#### 1. Router (`public/index.php`)
- Inicializa sesión
- Carga clases automáticamente
- Enruta acciones según `?action=`
- No contiene lógica de negocio

```php
// Acciones disponibles:
// ?action=login     → Muestra formulario de login
// ?action=dashboard → Muestra panel de usuarios
// ?action=logout    → Cierra la sesión
```

#### 2. Models (`app/Models/`)

**Database.php** - Gestión de conexión
- Crea conexión PDO a SQLite
- Inicializa tabla 'users'
- Inserta usuarios de prueba
- Proporciona métodos para ejecutar queries

**User.php** - Operaciones de usuario
```php
// VULNERABLE - Concatenación directa
loginVulnerable($username, $password)

// SEGURO - Prepared statements
loginSecure($username, $password)

// Otros métodos seguros
getAllUsers()       // Obtiene todos los usuarios
getUserById($id)    // Obtiene usuario por ID
createUser(...)     // Crea nuevo usuario
```

#### 3. Controllers (`app/Controllers/`)

**LoginController.php**
```php
showLoginForm()   // Renderiza formulario
handleLogin()     // Procesa POST del login
logout()          // Destruye sesión
```

**DashboardController.php**
```php
showDashboard()   // Renderiza vista de usuarios
              // Valida sesión
              // Obtiene lista de usuarios
```

#### 4. Views (`app/Views/`)

**login.php** - Formulario de login
- Diseño moderno con Tailwind
- Información educativa
- Validación en cliente

**dashboard.php** - Panel de usuarios
- Tabla responsive
- Información sobre vulnerabilidad
- Comparación: vulnerable vs seguro
- Botón de logout

#### 5. Base de Datos (`database/`)

**users.db** (SQLite)
```sql
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)
```

Datos de prueba insertados automáticamente.

### Flujo de Login Exitoso

```
Usuario escribe credenciales
         ↓
Login Form (HTML + JS)
         ↓
AJAX POST a index.php?action=login
         ↓
LoginController::handleLogin()
         ↓
UserModel::loginVulnerable() [VULNERABLE]
         ↓
SELECT * FROM users WHERE username = '' or '1'='1' ...
         ↓
Retorna primer usuario (bypass)
         ↓
Guarda en $_SESSION
         ↓
Retorna JSON: {success: true, redirect: 'index.php?action=dashboard'}
         ↓
JavaScript redirige a dashboard
         ↓
DashboardController::showDashboard()
         ↓
Renderiza dashboard.php (con lista de usuarios)
         ↓
Usuario ve tabla de usuarios
```

---

## 💀 Ejemplos de Ataques SQL Injection

### Ataque 1: Bypass Simple

```sql
Usuario: ' or 1=1 --
Contraseña: nada

Query resultante:
SELECT * FROM users WHERE username = '' or 1=1 --' AND password = 'nada'
                                       ^^^^^^^^
                                   Siempre verdadero

Resultado: Login como el primer usuario (admin)
```

### Ataque 2: Extracción de Datos

```sql
Usuario: admin' UNION SELECT id, username, password, email FROM users --
Contraseña: nada

Query resultante:
SELECT id, username, email, created_at FROM users WHERE 
username = 'admin' UNION SELECT id, username, password, email FROM users --'

Resultado: Se obtiene lista COMPLETA de contraseñas
```

### Ataque 3: Borrado de Datos (MUY PELIGROSO)

```sql
Usuario: admin'; DROP TABLE users; --
Contraseña: algo

Query resultante:
SELECT * FROM users WHERE username = 'admin'; DROP TABLE users; --'

Resultado: ¡LA TABLA SE BORRA!
```

### Ataque 4: Inyección Ciega (Time-Based)

```sql
Usuario: admin' AND (SELECT COUNT(*) FROM users WHERE username LIKE 'a%') > 0; --

Técnica: Si demora más, hay usuarios comenzando con 'a'
Resultado: Enumeración lenta pero efectiva de datos
```

### Ataque 5: Bypass Clásico

```sql
Usuario: ' or '1'='1
Contraseña: ' or '1'='1

Query resultante:
SELECT * FROM users WHERE username = '' or '1'='1' AND password = '' or '1'='1'

Resultado: Ambas condiciones verdaderas, SIEMPRE acceso
```

---

## 🛡️ Medidas de Defensa

### 1️⃣ Prepared Statements (MEJOR - Recomendado)

```php
// ❌ VULNERABLE
$sql = "SELECT * FROM users WHERE username = '" . $_POST['user'] . "'";
$result = $pdo->query($sql);

// ✅ SEGURO
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_POST['user']]);
$result = $stmt->fetch();
```

**Ventajas:**
- PDO trata placeholders como datos, no código SQL
- Imposible inyectar SQL
- Mejor performance (queries cacheadas)
- Standard de la industria

### 2️⃣ Validación de Entrada

```php
// Validar formato
if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
    throw new Exception('Username inválido');
}

// Validar tipo
if (!is_string($username)) {
    throw new Exception('Tipo incorrecto');
}

// Validar longitud
if (strlen($password) > 255) {
    throw new Exception('Contraseña muy larga');
}
```

### 3️⃣ Escaping (Menos Seguro)

```php
// MySQL
$user = $mysqli->real_escape_string($_POST['user']);

// PDO quote
$user = $pdo->quote($_POST['user']);
```

⚠️ **No confíes únicamente en escaping**, es propenso a errores.

### 4️⃣ Principio del Menor Privilegio

```sql
-- ❌ MAL
CREATE USER 'app'@'localhost' IDENTIFIED BY 'password';
GRANT ALL ON *.* TO 'app'@'localhost';

-- ✅ BIEN
CREATE USER 'app'@'localhost' IDENTIFIED BY 'password';
GRANT SELECT, INSERT, UPDATE ON database.* TO 'app'@'localhost';
```

El usuario de BD solo tiene permisos de lectura/escritura, no DROP/DELETE.

### 5️⃣ Usar ORMs

```php
// Doctrine ORM
$user = $em->getRepository(User::class)->findBy(['username' => $username]);

// Laravel Eloquent
$user = User::where('username', $username)->first();

// Estos ORMs usan prepared statements internamente
```

### 6️⃣ Input Whitelist (Lista Blanca)

```php
$allowedActions = ['login', 'logout', 'profile'];
$action = $_GET['action'] ?? 'login';

if (!in_array($action, $allowedActions)) {
    die('Acción no permitida');
}
```

### 7️⃣ Rate Limiting

```php
$attempts = cache_get('login_attempts_' . $ip, 0);

if ($attempts >= 5) {
    die('Demasiados intentos. Intenta en 15 minutos.');
}

cache_put('login_attempts_' . $ip, $attempts + 1, 15);
```

### 8️⃣ Logging y Monitoreo

```php
// Log intentos sospechosos
log_warning('Intento de login sospechoso', [
    'ip' => $_SERVER['REMOTE_ADDR'],
    'username' => $username,
    'payload' => $_POST
]);

// Detectar patrones de inyección
if (strpos($username, "' OR") !== false) {
    log_alert('Probable SQL Injection!');
}
```

---

## 📊 Comparación: Vulnerable vs Seguro

### Código Vulnerable

```php
<?php
// app/Models/User.php - VULNERABLE

class User {
    public function login($username, $password) {
        $sql = "SELECT * FROM users WHERE username = '" . $username . 
               "' AND password = '" . $password . "'";
        return $this->db->query($sql)->fetch();
    }
}
```

**Problemas:**
- ❌ Concatenación directa
- ❌ Sin validación
- ❌ Sin escape
- ❌ SQL visible en código

### Código Seguro (Opción 1: Prepared Statements)

```php
<?php
// app/Models/User.php - SEGURO

class User {
    public function login($username, $password) {
        $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username, $password]);
        return $stmt->fetch();
    }
}
```

**Ventajas:**
- ✅ Separación clara SQL/datos
- ✅ PDO maneja escaping
- ✅ Imposible inyección
- ✅ Mejor performance

### Código Seguro (Opción 2: Validación + Escaping)

```php
<?php
// app/Models/User.php - VALIDADO Y ESCAPADO

class User {
    public function login($username, $password) {
        if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
            throw new Exception('Username inválido');
        }
        
        $username = $this->db->quote($username);
        $password = $this->db->quote($password);
        
        $sql = "SELECT * FROM users WHERE username = {$username} AND password = {$password}";
        return $this->db->query($sql)->fetch();
    }
}
```

---

## 🚀 Cambiar a la Versión Segura

Para cambiar de vulnerable a seguro, edita:

**Archivo:** `app/Controllers/LoginController.php`

Cambia:
```php
// De:
$user = $this->userModel->loginVulnerable($username, $password);

// A:
$user = $this->userModel->loginSecure($username, $password);
```

Después, intenta las inyecciones SQL... ¡No funcionarán! 🛡️

---

## 📋 Checklist de Seguridad

- [ ] ¿Usas Prepared Statements para todas las queries?
- [ ] ¿Validas toda entrada de usuario?
- [ ] ¿Escapas salida HTML con htmlspecialchars()?
- [ ] ¿Usas HTTPS en producción?
- [ ] ¿Tienes rate limiting en login?
- [ ] ¿Logs de intentos fallidos?
- [ ] ¿Usuario DB con permisos mínimos?
- [ ] ¿Contraseñas hasheadas (bcrypt, argon2)?
- [ ] ¿Sesiones seguras (HttpOnly, Secure)?
- [ ] ¿Utilizas WAF (Web Application Firewall)?

---

## ❓ Preguntas Frecuentes

**P: ¿Es realmente vulnerable?**
R: Sí, intencionalmente. Es educacional.

**P: ¿Puedo usar esto en producción?**
R: **NO. Nunca. Nunca jamás.** Es solo para aprender.

**P: ¿Cómo lo hago más seguro?**
R: Usa los 8 métodos de defensa descritos arriba.

**P: ¿Necesito instalar algo más?**
R: No. Solo PHP 7.4+

**P: ¿Puedo modificar el código?**
R: Claro, está diseñado para eso.

**P: ¿Por qué no usa bcrypt?**
R: Porque es para aprender inyección SQL, no seguridad de contraseñas.

**P: ¿Cómo agrego más usuarios?**
R: La tabla se crea automáticamente. Edita `app/Models/Database.php` para agregar más datos de prueba.

**P: ¿Qué pasa si fuerzo la búsqueda?**
R: Los prepared statements en otros métodos te protegen.

---

## 🎓 Flujo de Aprendizaje Recomendado

```
1. Leer este README (10 min)
   ↓
2. Abrir la app en navegador (2 min)
   ↓
3. Hacer login normal (1 min)
   ↓
4. Intentar SQL Injection básica (2 min)
   ↓
5. Analizar el código en app/Models/User.php (10 min)
   ↓
6. Hacer más pruebas avanzadas (10 min)
   ↓
7. Leer sección de Arquitectura MVC (15 min)
   ↓
8. Analizar código fuente completo (20 min)
   ↓
9. Leer sección de Defensa (15 min)
   ↓
10. Modificar LoginController.php para usar loginSecure() (10 min)
   ↓
11. Verificar que injecciones ya no funcionan (5 min)
```

---

## 🔗 Conceptos Clave

- **SQL Injection:** Técnica que inserta código SQL malicioso
- **Prepared Statements:** Separa lógica SQL de datos (previene inyección)
- **Validación de Entrada:** Rechaza datos sospechosos
- **Escaping:** Escapa caracteres especiales (nivel básico de defensa)
- **MVC:** Patrón de arquitectura separando Models, Views, Controllers
- **PDO:** PHP Data Objects para manejo seguro de BD
- **OWASP Top 10:** Lista de los 10 riesgos de seguridad más críticos

---

## 📚 Recursos para Aprender Más

1. **OWASP Top 10** - SQL Injection está en #1
2. **OWASP SQL Injection Prevention Cheat Sheet**
3. **PHP PDO Documentation** - Prepared Statements
4. **CWE-89** - Improper Neutralization of Special Elements used in an SQL Command
5. **PortSwigger Web Security Academy** - SQL Injection Lab
6. **PentesterLab** - SQL Injection Challenges

---

## 🚨 Notas Importantes

⚠️ Esta aplicación es:
- ✅ **Educacional** - Diseñada para enseñar
- ✅ **Intencionalmente vulnerable** - Para ese propósito
- ✅ **Perfecta para aprender** - En ambiente seguro
- ❌ **NUNCA PARA PRODUCCIÓN** - No la uses en vivo

---

## 📞 Solución de Problemas

### "Address already in use"
```bash
# Usa otro puerto
php -S localhost:8002 -t public
```

### "SQLite database error"
```bash
# Verifica permisos de escritura
chmod 755 database/
```

### Estilos no cargan
- Abre F12 (Developer Tools)
- Verifica errores de conexión
- El CSS viene de CDN (TailwindCSS)

### Login no funciona
- Verifica que completaste ambos campos
- Intenta con las credenciales de prueba: `admin / admin123`
- Abre la consola del navegador para ver errores

---

## 🎯 Objetivos de Aprendizaje

Al completar esta práctica, habrás aprendido:

✅ Cómo funciona SQL Injection
✅ Por qué es una vulnerabilidad crítica
✅ Cómo explotarla (en ambiente seguro)
✅ Cómo prevenirla con 8 técnicas diferentes
✅ Arquitectura MVC en PHP
✅ Bases de datos SQLite
✅ Prepared Statements
✅ Seguridad web fundamental
✅ Análisis de código vulnerable
✅ Mejores prácticas de programación segura

---

## 🎓 Lecciones Clave

1. **NUNCA concatenes entrada de usuario en SQL queries**
2. **SIEMPRE usa Prepared Statements**
3. **Valida y sanitiza toda entrada**
4. **Confía en frameworks/librerías que lo hacen bien**
5. **Implementa el Principio del Menor Privilegio**
6. **Logging y monitoreo son fundamentales**
7. **La seguridad no es una característica, es un proceso**
8. **Educación > Auditoría > Implementación**

---

## 📝 Licencia

Uso educacional. Libre para modificar y distribuir con propósitos académicos.

---

## 📧 Contacto / Soporte

Este proyecto fue creado como herramienta educativa para aprender sobre seguridad web y SQL Injection.

Si tomas esta aplicación como punto de partida para un proyecto más grande, considera:
- Usar hashing para contraseñas (bcrypt, argon2)
- Implementar autenticación más robusta (JWT, sesiones seguras)
- Agregar validación de entrada más strict
- Usar un framework web (Laravel, Symfony)
- Implementar CSRF protection
- Agregar rate limiting real
- Usar HTTPS en producción

---

**¡Listo! Ahora tienes todo lo que necesitas para aprender sobre SQL Injection de forma segura. ¡Que disfrutes el aprendizaje! 🚀🎓**
# Inyeccion-SQL
