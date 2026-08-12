package repository

import (
	"database/sql"
	"encoding/csv"
	"fmt"
	"os"
	"strconv"
)

func ImportCSV(db *sql.DB, filePath string) error {
	// Verificar si la tabla ya tiene datos para evitar duplicar registros
	var count int
	err := db.QueryRow("SELECT COUNT(*) FROM consumptions").Scan(&count)
	if err == nil && count > 0 {
		fmt.Println("La tabla 'consumptions' ya contiene datos. Saltando importación.")
		return nil
	}

	file, err := os.Open(filePath)
	if err != nil {
		return fmt.Errorf("no se pudo abrir el archivo CSV: %v", err)
	}
	defer file.Close()

	reader := csv.NewReader(file)
	records, err := reader.ReadAll()
	if err != nil {
		return fmt.Errorf("error al leer el contenido del CSV: %v", err)
	}

	fmt.Println("Iniciando importación de datos a MySQL...")

	for _, record := range records {
		// Mapeo basado en tus columnas reales del CSV y la base de datos:
		// record[0] = id (UUID)
		// record[1] = meter_id
		// record[2] = active (valor numérico de consumo)
		// record[3] = date
		
		meterID, _ := strconv.Atoi(record[1])
		activeValue, _ := strconv.ParseFloat(record[2], 64)
		readingDate := record[3]

		// Insertando en las columnas de tu tabla 'consumptions'
		_, err := db.Exec(
			"INSERT INTO consumptions (meter_id, date, active, reactive_inductive, reactive_capacitive, exported) VALUES (?, ?, ?, 0, 0, 0)",
			meterID, readingDate, activeValue,
		)
		if err != nil {
			fmt.Printf("Error insertando registro: %v\n", err)
		}
	}

	fmt.Println("¡Importación de datos finalizada con éxito!")
	return nil
}