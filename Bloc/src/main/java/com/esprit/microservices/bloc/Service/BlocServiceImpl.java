package com.esprit.microservices.bloc.Service;

import com.esprit.microservices.bloc.Entity.Bloc;
import com.esprit.microservices.bloc.Repository.BlocRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class BlocServiceImpl implements IBlocService{

    @Autowired
    BlocRepository blocRepository ;


    @Override
    public List<Bloc> retrieveBlocs() {
        return blocRepository.findAll();
    }

    @Override
    public Bloc updateBloc(Bloc bloc) {
        return blocRepository.save(bloc);
    }

    @Override
    public Bloc addBloc(Bloc bloc) {
        return blocRepository.save(bloc);
    }

    @Override
    public Bloc retrieveBloc(long idBloc) {
        return blocRepository.findById(idBloc).orElse(null);
    }

    @Override
    public String removeBloc(long idBloc) {
        if (blocRepository.findById(idBloc).isPresent()) {
            blocRepository.deleteById(idBloc);
            return "candidat supprimé";
        } else
            return "candidat non supprimé";
    }


}
