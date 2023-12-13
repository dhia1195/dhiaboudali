package com.esprit.reservationn.repositery;


import com.esprit.reservationn.entities.Reservation;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.time.LocalDate;
import java.util.List;
@Repository
public interface ReservationRepo extends JpaRepository<Reservation,String> {
  //  long countResvationByAnneUniversitaireBetween(LocalDate debut, LocalDate fin);

    int countReservationByChambre_IdChambre(long idChambre);

    List<Reservation> findReservationByAnneUniversitaireBetween(LocalDate debutAnnee, LocalDate finAnnee);
}

