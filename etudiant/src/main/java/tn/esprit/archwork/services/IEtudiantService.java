package tn.esprit.archwork.services;

import tn.esprit.archwork.entities.Etudiant;

import java.util.List;

public interface IEtudiantService {
    List<Etudiant> retrieveAllEtudiants();

    List<Etudiant> addEtudiants (List<Etudiant> etudiants);

    Etudiant updateEtudiant (Etudiant e);


    Etudiant retrieveEtudiant(long idEtudiant);

    void removeEtudiant(long idEtudiant);

}
