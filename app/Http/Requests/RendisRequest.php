<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RendisRequest extends FormRequest
{
    public function authorize()
    {
        // You can add authorization logic here if needed
        return true; // Allow all users to make this request
    }

    public function rules()
    {
        return [
            'nomor_agenda' => 'required|string|max:255|unique:renstra_kadis,nomor_agenda,' . $this->route('renstra_kadis'),
            'nama_agenda_renstra' => 'required|string|max:255',
            'deskripsi_uraian_renstra' => 'required|string',
            'disposisi_diteruskan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:Active,Inactive',
        ];
    }

    public function messages()
    {
        return [
            'nomor_agenda.required' => 'Nomor Agenda is required.',
            'nomor_agenda.unique' => 'Nomor Agenda must be unique.',
            'nama_agenda_renstra.required' => 'Nama Agenda Renstra is required.',
            'deskripsi_uraian_renstra.required' => 'Deskripsi Uraian Renstra is required.',
            'disposisi_diteruskan.required' => 'Disposisi Diteruskan is required.',
            'tanggal_mulai.required' => 'Tanggal Mulai is required.',
            'tanggal_akhir.required' => 'Tanggal Akhir is required.',
            'tanggal_akhir.after_or_equal' => 'Tanggal Akhir must be after or equal to Tanggal Mulai.',
            'status.required' => 'Status is required.',
            'status.in' => 'Status must be either Active or Inactive.',
        ];
    }
}