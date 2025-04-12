package com.example.PaginaInicio.repository;

import com.example.PaginaInicio.model.TipoDispositivo;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface TipoDispositivoRepository extends JpaRepository<TipoDispositivo, Long> {

}
