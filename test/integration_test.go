package handler_test

import (
	"database/sql"
	"net/http"
	"net/http/httptest"
	"testing"

	_ "github.com/go-sql-driver/mysql"
	// Asegúrate de que esta ruta coincida con el módulo de tu go.mod
	"github.com/sebas90-cpu/bia-trackpower/internal/handler"
)

func TestIntegration_ConsumptionHandler(t *testing.T) {
	// 1. Conexión a la base de datos real local de XAMPP (MySQL)
	db, err := sql.Open("mysql", "root:@tcp(127.0.0.1:3306)/bia_energy")
	if err != nil {
		t.Fatalf("no se pudo abrir la conexión a la base de datos: %v", err)
	}
	defer db.Close()

	// 2. Verificamos que la base de datos esté encendida; si no, omitimos la prueba en lugar de fallar abruptamente
	if err := db.Ping(); err != nil {
		t.Skip("Saltando prueba de integración: la base de datos local no está disponible (verifica XAMPP)")
	}

	// 3. Preparamos una petición HTTP simulada con parámetros reales y válidos
	req, err := http.NewRequest("GET", "/consumption?meters_ids=1&start_date=2023-01-01&end_date=2023-12-31&kind_period=monthly", nil)
	if err != nil {
		t.Fatal(err)
	}

	rr := httptest.NewRecorder()

	// 4. Ejecutamos el handler pasando la conexión real a la base de datos
	h := handler.ConsumptionHandler(db)
	h.ServeHTTP(rr, req)

	// 5. Validamos que el sistema responda con un código HTTP 200 OK de integración exitosa
	if status := rr.Code; status != http.StatusOK {
		t.Errorf("la prueba de integración falló: se esperaba estado 200, se obtuvo %v", status)
	}
}
