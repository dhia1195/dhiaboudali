package tn.esprit.archwork.Respositories;

import org.springframework.data.jpa.repository.JpaRepository;
import tn.esprit.archwork.entities.Etudiant;

public interface EtudiantRepo extends JpaRepository<Etudiant,Long> {
    Etudiant findByCin(long cin);
}
