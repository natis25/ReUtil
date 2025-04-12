package com.example.PaginaInicio.service;

import com.example.PaginaInicio.model.TipoDispositivo;
import com.example.PaginaInicio.repository.TipoDispositivoRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class TipoDispositivoService {

    @Autowired
    private TipoDispositivoRepository tipoDispositivoRepository;

    // Listar todos
    public List<TipoDispositivo> listarTodos() {
        return tipoDispositivoRepository.findAll();
    }

    // Buscar por id
    public Optional<TipoDispositivo> obtenerPorId(Long id) {
        return tipoDispositivoRepository.findById(id);
    }

    // Crear o guardar
    public TipoDispositivo guardar(TipoDispositivo tipoDispositivo) {
        return tipoDispositivoRepository.save(tipoDispositivo);
    }

    // Actualizar
    public TipoDispositivo actualizar(Long id, TipoDispositivo nuevoTipoDispositivo) {
        return tipoDispositivoRepository.findById(id).map(tipoExistente -> {
            tipoExistente.setNombre_tipo(nuevoTipoDispositivo.getNombre_tipo());
            tipoExistente.setAceptado(nuevoTipoDispositivo.getAceptado());
            return tipoDispositivoRepository.save(tipoExistente);
        }).orElseThrow(() -> new RuntimeException("TipoDispositivo no encontrado con id " + id));
    }

    // Eliminar
    public void eliminar(Long id) {
        tipoDispositivoRepository.deleteById(id);
    }
}
