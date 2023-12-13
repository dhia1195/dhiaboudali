package com.esprit.reservationn.entities;

import com.fasterxml.jackson.annotation.JsonAnyGetter;
import jakarta.persistence.Entity;
import jakarta.persistence.Id;
import jakarta.persistence.ManyToOne;
import lombok.*;
import java.time.LocalDate;

@Entity
@Getter
@Setter
@AllArgsConstructor
@NoArgsConstructor

public class Reservation {
    @Id
    String idReservation;
    LocalDate anneUniversitaire;
    Boolean estValide;
    String statu;

    /*@ManyToMany(mappedBy = "reservationSet", cascade= CascadeType. PERSIST ,fetch = FetchType.LAZY )
   private List<Etudiant> etudiant ;*/
/* @OneToOne
Etudiant etudiant;*/
    @ManyToOne
    Chambre chambre;
    @ManyToOne
    Etudiant etudiant;
}



