package com.esprit.reservationn.repositery;


import com.esprit.reservationn.entities.Chambre;
import com.esprit.reservationn.entities.Reservation;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;
@Repository
public interface ChambreRepo extends JpaRepository<Chambre,Long> {

 //   List<Chambre> findChambresByBloc_NomBloc(String nom);

   Chambre findByNumChambre(long numChambre);

    //long countByTypeAndBloc(TypeChambre type, Bloc bloc);

    Chambre findByReservationsContains(Reservation reservation);

   // List<Chambre> findChambresNonReserveByTypeAndFoyer(TypeChambre type, Foyer foyer);

    // List<Chambre> findNonReservedRoomsByFoyerAndType(Foyer foyer, TypeChambre type);
}
