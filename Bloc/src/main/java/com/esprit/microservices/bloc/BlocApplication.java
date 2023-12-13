package com.esprit.microservices.bloc;

import com.esprit.microservices.bloc.Entity.Bloc;
import com.esprit.microservices.bloc.Repository.BlocRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.ApplicationRunner;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.cloud.client.discovery.EnableDiscoveryClient;
import org.springframework.cloud.netflix.eureka.EnableEurekaClient;
import org.springframework.context.annotation.Bean;

@SpringBootApplication
@EnableEurekaClient
public class BlocApplication {

	public static void main(String[] args) {
		SpringApplication.run(BlocApplication.class, args);
	}
	@Autowired
	private BlocRepository blocRepository;
	@Bean
	ApplicationRunner init() {
		return (args) -> {
			blocRepository.save(new Bloc("C",200));
			blocRepository.save(new Bloc("A",150));
			blocRepository.save(new Bloc("B",300));
			blocRepository.save(new Bloc("D",350));
			blocRepository.findAll().forEach(System.out::println);

		};

	}


}
