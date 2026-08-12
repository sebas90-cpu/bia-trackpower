package repository

import (
	"database/sql"
	"testing"

	_ "github.com/go-sql-driver/mysql"
)

// TestNewConsumptionRepository verifica que el constructor asigne correctamente la base de datos
func TestNewConsumptionRepository(t *testing.T) {
	db, err := sql.Open("mysql", "root:@tcp(127.0.0.1:3306)/bia_energy")
	if err != nil {
		t.Fatalf("no se esperaba un error al abrir la conexión: %v", err)
	}
	defer db.Close()

	repo := NewConsumptionRepository(db)
	if repo == nil {
		t.Errorf("se esperaba una instancia válida del repositorio, pero se obtuvo nil")
	}
	if repo.db != db {
		t.Errorf("la instancia de base de datos no coincide con la proporcionada")
	}
}

// TestGetAllConsumptions_QueryError valida la respuesta del repositorio ante un fallo de conexión o consulta
func TestGetAllConsumptions_QueryError(t *testing.T) {
	// Abrimos una conexión con un driver o configuración nula/cerrada para forzar el error en Query
	db, err := sql.Open("mysql", "usuario_falso:password_falso@tcp(127.0.0.1:3306)/base_falsa")
	if err != nil {
		t.Fatal(err)
	}

	// Forzamos el cierre inmediato para que la consulta falle controladamente
	db.Close()

	repo := NewConsumptionRepository(db)
	consumptions, err := repo.GetAllConsumptions()

	// Verificamos que devuelva un error al no haber conexión activa
	if err == nil {
		t.Errorf("se esperaba un error debido a la falta de conexión, pero se obtuvo nil")
	}
	if consumptions != nil {
		t.Errorf("se esperaba un slice nil de consumptions, pero se obtuvo contenido")
	}
}
