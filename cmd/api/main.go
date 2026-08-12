package main

import (
	"database/sql"
	"fmt"
	"log"
	"net/http"

	_ "github.com/go-sql-driver/mysql"
	"github.com/sebas90-cpu/bia-trackpower/internal/handler" // Importa tu nuevo paquete
	"github.com/sebas90-cpu/bia-trackpower/internal/repository"
)

func main() {
	db, _ := sql.Open("mysql", "root:@tcp(127.0.0.1:3306)/bia_energy")

	// Importar datos iniciales
	repository.ImportCSV(db, "data.csv")

	// Registrar ruta usando el handler modularizado
	http.HandleFunc("/consumption", handler.ConsumptionHandler(db))

	fmt.Println("Servidor corriendo en http://localhost:8080")
	log.Fatal(http.ListenAndServe(":8080", nil))
}
