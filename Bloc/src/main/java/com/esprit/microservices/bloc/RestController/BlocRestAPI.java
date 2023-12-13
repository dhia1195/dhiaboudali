package com.esprit.microservices.bloc.RestController;

import com.esprit.microservices.bloc.Entity.Bloc;
import com.esprit.microservices.bloc.Service.IBlocService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/bloc")

public class BlocRestAPI {
    @Autowired
    IBlocService iBlocService ;
    @GetMapping("/affichertout")
    List<Bloc> retrieveBlocs() {return iBlocService.retrieveBlocs();}
    @PutMapping("/modifierbloc")
    Bloc updateBloc(@RequestBody Bloc bloc){return iBlocService.updateBloc(bloc);}
    @PostMapping("/ajouterbloc")
    Bloc addBloc(@RequestBody Bloc bloc){return iBlocService.addBloc(bloc);}
    @GetMapping("/afficherbloc/{idBloc}")
    Bloc retrieveBloc(@PathVariable("idBloc") long idBloc){return iBlocService.retrieveBloc(idBloc);}
    @DeleteMapping("/supprimerbloc/{idBloc}")
    String removeBloc (@PathVariable("idBloc") long idBloc){return iBlocService.removeBloc(idBloc);}

}
