package com.esprit.reservationn.controller;



import com.esprit.reservationn.entities.Reservation;
import com.esprit.reservationn.service.IReservationService;
import lombok.AllArgsConstructor;
import org.springframework.format.annotation.DateTimeFormat;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;


import java.time.LocalDate;
import java.util.List;

@RestController
@AllArgsConstructor
@RequestMapping("/reservation")
@CrossOrigin(origins = "*")
public class ReservationRestController {
    IReservationService ireservationservice;

    @GetMapping("/getByAnneeUniversitaire/{deb}/{fin}")
    public List<Reservation> getReservationbyAnneeUniversitaire(
            @PathVariable("deb") @DateTimeFormat(pattern = "yyyy-MM-dd") LocalDate debutAnnee,
            @PathVariable("fin") @DateTimeFormat(pattern = "yyyy-MM-dd") LocalDate finAnnee
    ) {
        return ireservationservice.getReservationParAnneeUniversitaire(debutAnnee, finAnnee);
    }

    @GetMapping("/getAll")//
    public List<Reservation> getAllReservations() {
        return ireservationservice.getAll();
    }

    @GetMapping("/getById/{id}")
    public Reservation getReservationById(@PathVariable("id") String id) {
        return ireservationservice.getById(id);
    }

    @PostMapping("/add/{numChambre}/{cin}")//
    public ResponseEntity<Reservation>
    ajouterReservationEtAssignerAChambreEtAEtudiant(
            @PathVariable("numChambre") long numChambre,
            @PathVariable("cin") long cin
    ) {
        return ResponseEntity.ok(ireservationservice.ajouterReservationEtAssignerAChambreEtAEtudiant(numChambre, cin));
    }

    @PostMapping("/annulerReservation/{idReservation}")//a modifoer fi service
    public ResponseEntity<String>
    annulerReservation(
            @PathVariable("idReservation") String idReservation
    ) {
        return ireservationservice.annulerReservation(idReservation);
    }

    @PostMapping("/validerReservation/{idReservation}")
    public ResponseEntity<String>
    validerReservation(
            @PathVariable("idReservation") String idReservation
    ) {
        return ireservationservice.validerReservation(idReservation);
    }

    @PutMapping("/update")//
    public ResponseEntity<Reservation> updateUniversite(@RequestBody Reservation reservation){
        return ResponseEntity.ok(ireservationservice.updateReservation(reservation));
    }

}
