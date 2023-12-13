package com.esprit.microservices.bloc.Service;

import com.esprit.microservices.bloc.Entity.Bloc;

import java.util.List;

public interface IBlocService {
    List<Bloc> retrieveBlocs();

    Bloc updateBloc (Bloc  bloc);

    Bloc addBloc (Bloc bloc);

    Bloc retrieveBloc (long  idBloc);

    String removeBloc (long idBloc);


}
