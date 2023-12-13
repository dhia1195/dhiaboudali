package com.esprit.chambre.RestController;

import com.esprit.chambre.Service.IChambreService;
import com.esprit.chambre.entities.Chambre;
import lombok.AllArgsConstructor;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@AllArgsConstructor
@RequestMapping("/chambre")
public class ChambreRestController {
    IChambreService iChambreService;

    @GetMapping("/affichertout")
    List<Chambre> retrieveAllChambres() {
        return iChambreService.retrieveAllChambres();
    }
    @PostMapping("/ajouterchambre")
    Chambre addChambre(@RequestBody Chambre c) {
        return iChambreService.addChambre(c);
    }
    @PutMapping("/upadtechambre")
    Chambre updateChambre(@RequestBody Chambre c) {
        return iChambreService.updateChambre(c);
    }

    @GetMapping("/afficherchambre/{idchambre}")
    Chambre retrieveChambre(@PathVariable("idchambre") long idChambre) {

        return iChambreService.retrieveChambre(idChambre);

    }




}