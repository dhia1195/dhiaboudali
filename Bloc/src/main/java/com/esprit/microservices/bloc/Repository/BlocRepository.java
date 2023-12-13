package com.esprit.microservices.bloc.Repository;

import com.esprit.microservices.bloc.Entity.Bloc;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;

@Repository
public interface BlocRepository extends JpaRepository<Bloc, Long> {
    //Bloc findBlocByNomBloc(String nomB);
    //ou bien
    @Query("select b from Bloc b where b.nomBloc like :name")
    public Page<Bloc> blocByNom(@Param("name") String n, Pageable pageable);
}
