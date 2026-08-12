package main

import (
	"database/sql"
	"encoding/json"
	"fmt"
	"log"
	"net/http"

	_ "github.com/go-sql-driver/mysql"
	"github.com/sebas90-cpu/bia-trackpower/internal/repository"
)

type Consumption struct {
	ID      int     `json:"consumption_id"`
	MeterID int     `json:"meter_id"`
	Date    string  `json:"date"`
	Active  float64 `json:"active"`
}

func main() {
	dsn := "root:@tcp(127.0.0.1:3306)/bia_energy"
	db, err := sql.Open("mysql", dsn)
	if err != nil {
		log.Fatalf("Error al conectar con la base de datos: %v", err)
	}
	defer db.Close()

	if err := db.Ping(); err != nil {
		log.Fatalf("No se pudo comprobar la conexión con la base de datos: %v", err)
	}
	fmt.Println("¡Conexión exitosa a la base de datos MySQL!")

	// Ejecutamos la importación automática del archivo CSV si la tabla está vacía
	err = repository.ImportCSV(db, "data.csv")
	if err != nil {
		log.Printf("Aviso en la importación del CSV: %v", err)
	}

	http.HandleFunc("/consumption", func(w http.ResponseWriter, r *http.Request) {
		w.Header().Set("Content-Type", "application/json")

		rows, err := db.Query("SELECT consumption_id, meter_id, date, active FROM consumptions")
		if err != nil {
			w.WriteHeader(http.StatusInternalServerError)
			json.NewEncoder(w).Encode(map[string]string{"error": err.Error()})
			return
		}
		defer rows.Close()

		var consumptions []Consumption
		for rows.Next() {
			var c Consumption
			if err := rows.Scan(&c.ID, &c.MeterID, &c.Date, &c.Active); err != nil {
				continue
			}
			consumptions = append(consumptions, c)
		}

		if err := rows.Err(); err != nil {
			w.WriteHeader(http.StatusInternalServerError)
			json.NewEncoder(w).Encode(map[string]string{"error": err.Error()})
			return
		}

		if consumptions == nil {
			consumptions = []Consumption{}
		}

		w.WriteHeader(http.StatusOK)
		json.NewEncoder(w).Encode(consumptions)
	})

	fmt.Println("Servidor corriendo en http://localhost:8080")
	if err := http.ListenAndServe(":8080", nil); err != nil {
		log.Fatalf("Error al iniciar el servidor: %v", err)
	}
}
