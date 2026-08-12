package http

import (
	"encoding/json"
	"net/http"

	"github.com/sebas90-cpu/bia-trackpower/internal/repository"
)

type ConsumptionHandler struct {
	repo *repository.ConsumptionRepository
}

func NewConsumptionHandler(repo *repository.ConsumptionRepository) *ConsumptionHandler {
	return &ConsumptionHandler{repo: repo}
}

func (h *ConsumptionHandler) GetConsumptions(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json")

	consumptions, err := h.repo.GetAllConsumptions()
	if err != nil {
		w.WriteHeader(http.StatusInternalServerError)
		json.NewEncoder(w).Encode(map[string]string{"error": err.Error()})
		return
	}

	w.WriteHeader(http.StatusOK)
	json.NewEncoder(w).Encode(consumptions)
}
