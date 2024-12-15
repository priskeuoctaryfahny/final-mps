<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class RendisExport implements FromCollection, WithHeadings, ShouldAutoSize, WithChunkReading
{
    protected $rendis;
    protected $selectedColumns;

    public function __construct($rendis, $selectedColumns)
    {
        $this->rendis = $rendis;
        $this->selectedColumns = $selectedColumns;
    }

    public function collection()
    {
        return $this->rendis->map(function ($rendis, $index) {
            $data = [];
            $data['No'] = $index + 1;
            if (in_array('nomor_agenda', $this->selectedColumns)) {
                $data['nomor_agenda'] = $rendis->nomor_agenda;
            }
            if (in_array('nama_agenda_renstra', $this->selectedColumns)) {
                $data['nama_agenda_renstra'] = $rendis->nama_agenda_renstra;
            }
            if (in_array('deskripsi_uraian_renstra', $this->selectedColumns)) {
                $data['deskripsi_uraian_renstra'] = $rendis->deskripsi_uraian_renstra;
            }
            if (in_array('disposisi_diteruskan', $this->selectedColumns)) {
                $data['disposisi_diteruskan'] = $rendis->disposisi_diteruskan;
            }
            if (in_array('tanggal_mulai', $this->selectedColumns)) {
                $data['tanggal_mulai'] = $rendis->tanggal_mulai;
            }
            if (in_array('tanggal_akhir', $this->selectedColumns)) {
                $data['tanggal_akhir'] = $rendis->tanggal_akhir;
            }
            if (in_array('status', $this->selectedColumns)) {
                $data['status'] = $rendis->status;
            }

            if (in_array('is_terlaksana', $this->selectedColumns)) {
                $data['is_terlaksana'] = $rendis->is_terlaksana;
            }

            return $data;
        });
    }

    public function headings(): array
    {
        $headings = [];
        $headings[] = 'No';
        if (in_array('nomor_agenda', $this->selectedColumns)) {
            $headings[] = 'Nomor Agenda';
        }
        if (in_array('nama_agenda_renstra', $this->selectedColumns)) {
            $headings[] = 'Nama Agenda';
        }
        if (in_array('deskripsi_uraian_renstra', $this->selectedColumns)) {
            $headings[] = 'Deskripsi Uraian';
        }

        if (in_array('disposisi_diteruskan', $this->selectedColumns)) {
            $headings[] = 'Disposisi Diteruskan';
        }

        if (in_array('tanggal_mulai', $this->selectedColumns)) {
            $headings[] = 'Tanggal Mulai';
        }
        if (in_array('tanggal_akhir', $this->selectedColumns)) {
            $headings[] = 'Tanggal Akhir';
        }
        if (in_array('status', $this->selectedColumns)) {
            $headings[] = 'Status';
        }
        if (in_array('is_terlaksana', $this->selectedColumns)) {
            $headings[] = 'Is Terlaksana';
        }

        return $headings;
    }

    public function chunkSize(): int
    {
        return 1000; // Adjust the chunk size as needed
    }
}
