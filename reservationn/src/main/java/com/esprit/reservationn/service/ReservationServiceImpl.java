package com.esprit.reservationn.service;



import com.esprit.reservationn.entities.Chambre;
import com.esprit.reservationn.entities.Etudiant;
import com.esprit.reservationn.entities.Reservation;
import com.esprit.reservationn.repositery.ChambreRepo;
import com.esprit.reservationn.repositery.EtudiantRepo;
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
    ChambreRepo chambrerepo;
    EtudiantRepo etudianrepo;

    @Override
   public Reservation add(Reservation reservation) {
        return resRepo.save(reservation);
    }

    @Override
    public Reservation ajouterReservationEtAssignerAChambreEtAEtudiant(
            long numChambre,
            long cin
    ) {
        Chambre chambre = chambrerepo.findByNumChambre(numChambre);
        if (chambre == null) {
            throw new RuntimeException("Chambre introuvable");
        }
        boolean available = resRepo.
                countReservationByChambre_IdChambre(chambre.getIdChambre())
                <
                typeCToInt(chambre.getType().toString());

        Etudiant etudiant = etudianrepo.findByCin(cin);
        if (etudiant == null) {
            throw new RuntimeException("Étudiant introuvable");
        }
        Reservation reservation = new Reservation();

        reservation.setIdReservation(
                LocalDate.now().getYear() + "/" +
                        (LocalDate.now().getYear() + 1 )+ "-"
                        + chambre.getNumChambre() + "-"
                        + etudiant.getCin()
        );

        if (available) {
            resRepo.save(reservation);
            reservation.setEtudiant(etudiant);
            reservation.setChambre(chambre);
            reservation.setEstValide(true);
            reservation.setAnneUniversitaire(LocalDate.now());
            reservation.setStatu("en-cours");
            resRepo.save(reservation);
        } else {
            throw new RuntimeException("pas de place disponible");
        }

        return resRepo.findById(reservation.getIdReservation()).orElse(null);

    }

    @Override
    public List<Reservation> getReservationParAnneeUniversitaire(
            LocalDate debutAnnee,
            LocalDate finAnnee
    ) {
        return resRepo.findReservationByAnneUniversitaireBetween(debutAnnee, finAnnee);
    }
    @Override
    public ResponseEntity<String> annulerReservation(String idReservation) {
        try {
            Reservation reservation = resRepo.findById(idReservation).orElse(null);
            reservation.setStatu("annule");
            reservation.setEtudiant(null);
            reservation.setChambre(null);
            reservation.setEstValide(false);
            resRepo.save(reservation);
            return ResponseEntity.ok().body("reservation annule");
        }catch (NullPointerException ex){
            throw new RuntimeException("reservation not found");
        }

    }

    @Override
    public ResponseEntity<String> validerReservation(String idReservation) {
        try {
            Reservation reservation = resRepo.findById(idReservation).orElse(null);
            reservation.setStatu("valide");
            reservation.setEtudiant(null);
            reservation.setChambre(null);
            reservation.setEstValide(false);
            resRepo.save(reservation);
            return ResponseEntity.ok().body("reservation valide");
        }catch (NullPointerException ex){
            throw new RuntimeException("reservation not found");
        }

    }


    @Override
    public List<Reservation> getAll() {
        return resRepo.findAll();
    }

    @Override
    public Reservation getById(String id) {
        return resRepo.findById(id).orElse(null);
    }

    @Override
    public Reservation updateReservation(Reservation res) {
        return resRepo.save(res);
    }




    public int typeCToInt(String typeC) {
        switch (typeC) {
            case "SIMPLE":
                return 1;
            case "DOUBLE":
                return 2;
            case "TRIPLE":
                return 3;
            default:
                return 0;
        }
    }

}
