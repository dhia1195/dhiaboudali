package com.esprit.microservices.bloc.Entity;


import javax.persistence.*;
import java.util.Set;

@Entity

public class Bloc {


    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private long idBloc;
    String nomBloc;
    long capaciteBloc;

    public long getIdBloc() {
        return idBloc;
    }

    public void setIdBloc(long idBloc) {
        this.idBloc = idBloc;
    }

    public String getNomBloc() {
        return nomBloc;
    }

    public void setNomBloc(String nomBloc) {
        this.nomBloc = nomBloc;
    }

    public long getCapaciteBloc() {
        return capaciteBloc;
    }

    public void setCapaciteBloc(long capaciteBloc) {
        capaciteBloc = capaciteBloc;
    }

    public Bloc() {
        super();
    }

    public Bloc(String nomBloc ,long capaciteBloc) {
        super();
        this.nomBloc = nomBloc;
        this.capaciteBloc = capaciteBloc ;
    }



}
