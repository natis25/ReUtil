package com.example.PaginaInicio.controller;
import com.example.PaginaInicio.repository.EmpleadoRepository;
import com.example.PaginaInicio.service.EmpleadoService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import com.example.PaginaInicio.model.Empleado;

import java.util.List;

@RestController
@RequestMapping("/api/usuarios")
public class EmpleadoController {

    @Autowired
    private EmpleadoService usuarioService;

    @GetMapping
    public List<Empleado> listarUsuarios() {
        return usuarioService.obtenerTodosLosEmpleados();
    }

    

}