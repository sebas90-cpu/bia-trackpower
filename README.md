# ⚡ BIA Energy - Microservicio de Consumos

Microservicio backend desarrollado en **Go** para la gestión y consulta de consumos energéticos, diseñado bajo una arquitectura limpia por capas y conectado a bases de datos relacionales.

---

## 🚀 Características Principales
* **API REST en Go:** Endpoints eficientes y estructurados para el manejo de consumos.
* **Capa de Repositorio:** Conexión segura a base de datos MySQL mediante `database/sql`.
* **Pruebas Unitarias:** Validación de lógica de handlers y manejo de errores en repositorios.
* **Pruebas de Integración:** Verificación de flujos de extremo a extremo conectados a la base de datos local.

---

## 📂 Estructura del Proyecto

```text
.
├── cmd/
│   └── api/
│       └── main.go
├── internal/
│   ├── delivery/
│   ├── domain/
│   ├── handler/
│   │   ├── consumption_handler.go
│   │   └── handler_test.go
│   ├── repository/
│   │   ├── consumption_repository.go
│   │   └── repository_test.go
│   └── usecase/
├── test/
│   └── integration_test.go
├── go.mod
└── go.sum
