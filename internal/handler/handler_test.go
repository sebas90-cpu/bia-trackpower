package handler

import (
	"net/http"
	"net/http/httptest"
	"testing"
)

func TestConsumptionHandler_MissingParams(t *testing.T) {
	// Creamos una petición HTTP sin los parámetros obligatorios (meters_ids, start_date, end_date)
	req, err := http.NewRequest("GET", "/consumption", nil)
	if err != nil {
		t.Fatal(err)
	}

	rr := httptest.NewRecorder()

	// Pasamos nil como base de datos ya que la validación de parámetros ocurre antes de consultar la BD
	handler := ConsumptionHandler(nil)
	handler.ServeHTTP(rr, req)

	// Verificamos que responda con el código HTTP 400 (Bad Request)
	if status := rr.Code; status != http.StatusBadRequest {
		t.Errorf("código de estado incorrecto: se obtuvo %v, se esperaba %v", status, http.StatusBadRequest)
	}
}
