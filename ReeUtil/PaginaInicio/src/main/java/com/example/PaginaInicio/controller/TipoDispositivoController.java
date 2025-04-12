package com.example.PaginaInicio.controller;

import com.example.PaginaInicio.model.TipoDispositivo;
import com.example.PaginaInicio.service.TipoDispositivoService;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;
import org.springframework.ui.Model;
import org.springframework.stereotype.Controller;

import java.util.Optional;

@Controller
@RequestMapping("/tipoDispositivo")
public class TipoDispositivoController {

    @Autowired
    private TipoDispositivoService servicio;

    @GetMapping("/tipoDispositivo")
    public String verPaginaTipoDispositivo(Model model) {
        model.addAttribute("listaTipoDispositivo", servicio.listarTodos());
        return "tipoDispositivo"; // esto busca un tipoDispositivo.html en templates
    }

    @GetMapping
    public String listar(Model model) {
        model.addAttribute("tipos", servicio.listarTodos());
        return "/listar";
    }

    @GetMapping("/nuevo")
    public String nuevo(Model model) {
        model.addAttribute("tipoDispositivo", new TipoDispositivo());
        return "/crud";
    }

    @PostMapping("/guardar")
    public String guardar(@ModelAttribute TipoDispositivo tipo) {
        servicio.guardar(tipo);
        return "redirect:/tipoDispositivo";
    }

    @GetMapping("/editar/{id}")
    public String editar(@PathVariable Long id, Model model) {
        Optional<TipoDispositivo> tipoOptional = servicio.obtenerPorId(id);
        if (tipoOptional.isPresent()) {
            TipoDispositivo tipo = tipoOptional.get();
            model.addAttribute("tipoDispositivo", tipo);
            return "tipoDispositivo/form";
        } else {
            // Maneja el caso en que el tipo no se encuentra, como redirigir a otra página
            return "redirect:/tipoDispositivo"; // O el manejo adecuado
        }
    }

    @GetMapping("/eliminar/{id}")
    public String eliminar(@PathVariable Long id) {
        servicio.eliminar(id);
        return "redirect:/tipoDispositivo";
    }
}
