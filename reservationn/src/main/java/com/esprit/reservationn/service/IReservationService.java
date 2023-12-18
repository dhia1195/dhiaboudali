package com.esprit.reservationn.service;


import com.esprit.reservationn.entities.Reservation;
import org.springframework.http.ResponseEntity;

import java.time.LocalDate;
import java.util.List;

public interface IReservationService {

    List<Reservation> retrieveAllReservation();
    Reservation addReservation(Reservation b);
    Reservation updateReservation (Reservation b);
    List<Reservation> delete (Reservation reservation);
    public void deleteReservation (String idReservation);
    }





