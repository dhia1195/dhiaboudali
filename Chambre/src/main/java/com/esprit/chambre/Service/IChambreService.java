package com.esprit.chambre.Service;


import com.esprit.chambre.entities.Chambre;
import com.esprit.chambre.entities.TypeChambre;

import java.util.List;

public interface IChambreService {

    List<Chambre> retrieveAllChambres();

    Chambre  addChambre(Chambre c); // ajouter l’équipe avec son détail

    Chambre updateChambre (Chambre  c);

    Chambre retrieveChambre (long idChambre);






}
