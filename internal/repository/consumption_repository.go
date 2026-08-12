package repository

import (
	"database/sql"
)

type Consumption struct {
	ConsumptionID      int     `json:"consumption_id"`
	MeterID            int     `json:"meter_id"`
	Date               string  `json:"date"`
	Active             float64 `json:"active"`
	ReactiveInductive  float64 `json:"reactive_inductive"`
	ReactiveCapacitive float64 `json:"reactive_capacitive"`
	Exported           float64 `json:"exported"`
}

type ConsumptionRepository struct {
	db *sql.DB
}

func NewConsumptionRepository(db *sql.DB) *ConsumptionRepository {
	return &ConsumptionRepository{db: db}
}

func (r *ConsumptionRepository) GetAllConsumptions() ([]Consumption, error) {
	rows, err := r.db.Query("SELECT consumption_id, meter_id, date, active, reactive_inductive, reactive_capacitive, exported FROM consumptions LIMIT 100")
	if err != nil {
		return nil, err
	}
	defer rows.Close()

	var consumptions []Consumption
	for rows.Next() {
		var c Consumption
		err := rows.Scan(&c.ConsumptionID, &c.MeterID, &c.Date, &c.Active, &c.ReactiveInductive, &c.ReactiveCapacitive, &c.Exported)
		if err != nil {
			return nil, err
		}
		consumptions = append(consumptions, c)
	}

	if err := rows.Err(); err != nil {
		return nil, err
	}

	return consumptions, nil
}
