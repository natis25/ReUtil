package com.example.PaginaInicio.repository;

import org.springframework.data.jpa.repository.JpaRepository;

import com.example.PaginaInicio.model.Empleado;

import java.util.Optional;


public interface EmpleadoRepository extends JpaRepository<Empleado, Long> {
    // ¡Ya incluye findAll() automáticamente!

    Optional<Empleado> findByCorreoAndContrasena(String correo, String contrasena);
}

