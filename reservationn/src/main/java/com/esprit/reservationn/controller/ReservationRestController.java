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
@RequestMapping("/reservations")
@CrossOrigin(origins = "*")
public class ReservationRestController {
    IReservationService ireservationservice;

    @GetMapping("/afficheruniversites")
    List<Reservation> retrieveAllReservation(){

        return ireservationservice.retrieveAllReservation();
    }
    @PostMapping("/ajouteruniversite")
    Reservation addUniversite(@RequestBody Reservation c){return ireservationservice.addReservation(c);}
    @PutMapping("/modifieruniversite")
    Reservation updateReservation (@RequestBody Reservation c){return ireservationservice.updateReservation(c);}

    @DeleteMapping("/deleteReservation/{id}")
    public void deleteReservation(@PathVariable ("id") String idReservation){
        ireservationservice.deleteReservation(idReservation);
    }

}
