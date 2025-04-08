package com.example.PaginaInicio.service;


import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.example.PaginaInicio.model.Empleado;
import com.example.PaginaInicio.repository.EmpleadoRepository;

import java.util.List;

@Service
public class EmpleadoService {

    @Autowired
    private EmpleadoRepository usuarioRepository;

    public List<Empleado> obtenerTodosLosEmpleados() {
        return usuarioRepository.findAll();
    }


    public boolean validarInicioSesion(String correo, String contrasena) {
        return usuarioRepository.findByCorreoAndContrasena(correo, contrasena).isPresent();
    }
}
