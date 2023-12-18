package com.esprit.reservationn.service;



import com.esprit.reservationn.entities.Reservation;
import com.esprit.reservationn.repositery.ReservationRepo;
import lombok.AllArgsConstructor;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Service;

import java.time.LocalDate;
import java.util.List;

@Service
@AllArgsConstructor
public class ReservationServiceImpl implements IReservationService {
    ReservationRepo resRepo;


    @Override
    public List<Reservation> retrieveAllReservation() {
        return resRepo.findAll();
    }

    @Override
    public Reservation addReservation(Reservation b) {
        return resRepo.save(b);
    }



    @Override
    public Reservation updateReservation(Reservation b) {
        return resRepo.save(b);    }



    @Override
    public List<Reservation> delete(Reservation reservation) {
        resRepo.delete(reservation);
        return resRepo.findAll();
    }

    @Override
    public void deleteReservation(String idReservation) {
        resRepo.deleteById(idReservation);
    }
}


