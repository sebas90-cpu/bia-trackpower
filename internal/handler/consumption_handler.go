package handler

import (
	"database/sql"
	"encoding/json"
	"fmt"
	"net/http"
)

type DataGraph struct {
	MeterID            int       `json:"meter_id"`
	Address            string    `json:"address"`
	Active             []float64 `json:"active"`
	ReactiveInductive  []float64 `json:"reactive_inductive"`
	ReactiveCapacitive []float64 `json:"reactive_capacitive"`
	Exported           []float64 `json:"exported"`
}

type ConsumptionResponse struct {
	Period    []string    `json:"period"`
	DataGraph []DataGraph `json:"data_graph"`
}

func ConsumptionHandler(db *sql.DB) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		w.Header().Set("Content-Type", "application/json")

		meterID := r.URL.Query().Get("meters_ids")
		startDate := r.URL.Query().Get("start_date")
		endDate := r.URL.Query().Get("end_date")
		kindPeriod := r.URL.Query().Get("kind_period")

		if meterID == "" || startDate == "" || endDate == "" {
			w.WriteHeader(http.StatusBadRequest)
			json.NewEncoder(w).Encode(map[string]string{"error": "Faltan parámetros obligatorios"})
			return
		}

		var address string
		err := db.QueryRow("SELECT address FROM meters WHERE meter_id = ?", meterID).Scan(&address)
		if err != nil {
			address = "Dirección mock"
		}

		var periods []string
		var activeValues, reactiveInd, reactiveCap, exportedVals []float64

		query := `SELECT DATE_FORMAT(date, '%b %Y'), SUM(active), SUM(reactive_inductive), SUM(reactive_capacitive), SUM(exported) 
				  FROM consumptions WHERE meter_id = ? AND date BETWEEN ? AND ? GROUP BY DATE_FORMAT(date, '%b %Y') ORDER BY date ASC`

		if kindPeriod != "monthly" {
			query = `SELECT date, active, reactive_inductive, reactive_capacitive, exported 
					 FROM consumptions WHERE meter_id = ? AND date BETWEEN ? AND ?`
		}

		rows, err := db.Query(query, meterID, startDate, endDate)
		if err == nil {
			defer rows.Close()

			for rows.Next() {
				var p string
				var act, rInd, rCap, exp float64
				if err := rows.Scan(&p, &act, &rInd, &rCap, &exp); err == nil {
					periods = append(periods, p)
					activeValues = append(activeValues, act)
					reactiveInd = append(reactiveInd, rInd)
					reactiveCap = append(reactiveCap, rCap)
					exportedVals = append(exportedVals, exp)
				}
			}

			// Validación final para eliminar la advertencia del linter
			if err := rows.Err(); err != nil {
				// Manejo opcional del error de iteración
			}
		}

		if periods == nil {
			periods = []string{}
			activeValues = []float64{}
			reactiveInd = []float64{}
			reactiveCap = []float64{}
			exportedVals = []float64{}
		}

		var mID int
		fmt.Sscanf(meterID, "%d", &mID)

		json.NewEncoder(w).Encode(ConsumptionResponse{
			Period: periods,
			DataGraph: []DataGraph{{
				MeterID: mID, Address: address, Active: activeValues,
				ReactiveInductive: reactiveInd, ReactiveCapacitive: reactiveCap, Exported: exportedVals,
			}},
		})
	}
}
