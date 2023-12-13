package com.esprit.reservationn.repositery;


import com.esprit.reservationn.entities.Etudiant;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface EtudiantRepo extends JpaRepository<Etudiant,Long> {
    Etudiant findByCin(long cin);
}
