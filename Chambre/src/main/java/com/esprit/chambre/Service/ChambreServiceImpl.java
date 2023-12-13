package com.esprit.chambre.Service;

import com.esprit.chambre.entities.Chambre;
import com.esprit.chambre.entities.TypeChambre;
import com.esprit.chambre.repository.ChambreRepo;
import lombok.AllArgsConstructor;
import org.springframework.stereotype.Service;


import java.util.List;

@Service
@AllArgsConstructor
public class ChambreServiceImpl implements IChambreService {
    ChambreRepo chambreRepo;
   // BlocRepo blocRepo;
    //FoyerRepo foyerRepo;
//    UniversiteRepo universiteRepo;

    @Override
    public List<Chambre> retrieveAllChambres() {
        return chambreRepo.findAll();
    }

    @Override
    public Chambre addChambre(Chambre c) {
        return chambreRepo.save(c);
    }

    @Override
    public Chambre updateChambre(Chambre c) {
        return chambreRepo.save(c);
    }

    @Override
    public Chambre retrieveChambre(long idChambre) {
        return chambreRepo.findById(idChambre).orElse( null);  //or .get pour forcer
    }






}
