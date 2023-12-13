package com.esprit.reservationn.entities;

import com.fasterxml.jackson.annotation.JsonIgnore;
import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;

import java.util.Date;
import java.util.List;
import java.util.Set;

@Entity
@Getter
@Setter
@AllArgsConstructor
@NoArgsConstructor
public class Etudiant {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long idEtudiant;
    String nomEt;
    String prenomEt;
    long cin;
    String ecole;
    @Temporal(TemporalType.DATE)
    Date dateNaissance;
    @JsonIgnore
   /* @OneToOne(mappedBy = "etudiant")
    Reservation reservation;*/
    @OneToMany(mappedBy = "etudiant")  //sans parametre 5tr chambre invisible
    Set<Reservation> reservations;
     @ManyToMany(cascade = CascadeType. ALL , fetch = FetchType.EAGER )
        private List<Reservation> reservation ;

}
