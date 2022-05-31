<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':Attribute harus diterima.',
    'accepted_if'          => ':Attribute harus diterima ketika :other berisi :value.',
    'active_url'           => ':Attribute bukan URL.',
    'after'                => ':Attribute harus berisi tanggal setelah :date.',
    'after_or_equal'       => ':Attribute harus berisi tanggal setelah atau sama dengan :date.',
    'alpha'                => ':Attribute hanya boleh berisi huruf.',
    'alpha_dash'           => ':Attribute hanya boleh berisi huruf, angka, strip, dan garis bawah.',
    'alpha_num'            => ':Attribute hanya boleh berisi huruf dan angka.',
    'array'                => ':Attribute harus berisi sebuah array.',
    'before'               => ':Attribute harus berisi tanggal sebelum :date.',
    'before_or_equal'      => ':Attribute harus berisi tanggal sebelum atau sama dengan :date.',
    'between'              => [
        'array'   => ':Attribute harus memiliki :min sampai :max anggota.',
        'file'    => ':Attribute harus berukuran antara :min sampai :max kb.',
        'numeric' => ':Attribute minimal :min maksimal :max.',
        'string'  => ':Attribute harus :min - :max karakter.',
    ],
    'boolean'              => ':Attribute harus bernilai true atau false',
    'confirmed'            => 'Konfirmasi :attribute tidak cocok.',
    'current_password'     => 'Kata sandi salah.',
    'date'                 => ':Attribute bukan tanggal.',
    'date_equals'          => ':Attribute harus tanggal :date.',
    'date_format'          => ':Attribute harus berformat :format.',
    'declined'             => ':Attribute ini ditolak.',
    'declined_if'          => ':Attribute ini ditolak ketika :other bernilai :value.',
    'different'            => ':Attribute dan :other harus berbeda.',
    'digits'               => ':Attribute harus terdiri dari :digits angka.',
    'digits_between'       => ':Attribute minimal :min dan maksimal :max angka.',
    'dimensions'           => ':Attribute tidak berdimensi gambar.',
    'distinct'             => ':Attribute duplikat.',
    'email'                => ':Attribute harus berupa alamat surel.',
    'ends_with'            => ':Attribute harus diakhiri dengan: :values',
    'enum'                 => ':Attribute tidak sesuai.',
    'exists'               => ':Attribute tidak sesuai atau terhapus.',
    'file'                 => ':Attribute harus berupa berkas.',
    'filled'               => ':Attribute harus diisi.',
    'gt'                   => [
        'array'   => ':Attribute harus memiliki lebih dari :value anggota.',
        'file'    => ':Attribute harus berukuran lebih besar dari :value kilobita.',
        'numeric' => ':Attribute harus bernilai lebih besar dari :value.',
        'string'  => ':Attribute harus berisi lebih besar dari :value karakter.',
    ],
    'gte'                  => [
        'array'   => ':Attribute harus terdiri dari :value anggota atau lebih.',
        'file'    => ':Attribute harus berukuran lebih besar dari atau sama dengan :value kilobita.',
        'numeric' => ':Attribute harus bernilai lebih besar dari atau sama dengan :value.',
        'string'  => ':Attribute harus berisi lebih besar dari atau sama dengan :value karakter.',
    ],
    'image'                => ':Attribute harus berupa gambar.',
    'in'                   => ':Attribute tidak sesuai.',
    'in_array'             => ':Attribute tidak ada di dalam :other.',
    'integer'              => ':Attribute harus bilangan bulat.',
    'ip'                   => ':Attribute harus berupa alamat IP.',
    'ipv4'                 => ':Attribute harus berupa alamat IPv4.',
    'ipv6'                 => ':Attribute harus berupa alamat IPv6.',
    'json'                 => ':Attribute harus berupa JSON string.',
    'lt'                   => [
        'array'   => ':Attribute harus memiliki kurang dari :value anggota.',
        'file'    => ':Attribute harus berukuran kurang dari :value kilobita.',
        'numeric' => ':Attribute harus bernilai kurang dari :value.',
        'string'  => ':Attribute harus berisi kurang dari :value karakter.',
    ],
    'lte'                  => [
        'array'   => ':Attribute harus tidak lebih dari :value anggota.',
        'file'    => ':Attribute harus berukuran kurang dari atau sama dengan :value kilobita.',
        'numeric' => ':Attribute harus bernilai kurang dari atau sama dengan :value.',
        'string'  => ':Attribute harus berisi kurang dari atau sama dengan :value karakter.',
    ],
    'mac_address'          => ':Attribute harus berupa alamat MAC.',
    'max'                  => [
        'array'   => ':Attribute maksimal :max data.',
        'file'    => ':Attribute maksimal :max kb.',
        'numeric' => ':Attribute maksimal :max.',
        'string'  => ':Attribute maksimal :max karakter.',
    ],
    'mimes'                => ':Attribute harus berupa berkas berjenis: :values.',
    'mimetypes'            => ':Attribute harus berupa berkas berjenis: :values.',
    'min'                  => [
        'array'   => ':Attribute minimal :min data.',
        'file'    => ':Attribute minimal :min kb.',
        'numeric' => ':Attribute minimal :min.',
        'string'  => ':Attribute minimal :min karakter.',
    ],
    'multiple_of'          => ':Attribute harus merupakan kelipatan dari :value',
    'not_in'               => ':Attribute tidak sesuai.',
    'not_regex'            => 'Format :attribute tidak sesuai.',
    'numeric'              => ':Attribute harus berupa angka.',
    'password'             => 'Kata sandi salah.',
    'present'              => ':Attribute wajib ada.',
    'prohibited'           => ':Attribute tidak boleh ada.',
    'prohibited_if'        => ':Attribute tidak boleh ada bila :other adalah :value.',
    'prohibited_unless'    => ':Attribute tidak boleh ada kecuali :other memiliki nilai :values.',
    'prohibits'            => ':Attribute melarang isian :other untuk ditampilkan.',
    'regex'                => 'Format :attribute tidak valid.',
    'required'             => ':Attribute wajib diisi.',
    'required_array_keys'  => ':Attribute wajib berisi entri untuk: :values.',
    'required_if'          => ':Attribute wajib diisi bila :other adalah :value.',
    'required_unless'      => ':Attribute wajib diisi kecuali :other memiliki nilai :values.',
    'required_with'        => ':Attribute wajib diisi bila terdapat :values.',
    'required_with_all'    => ':Attribute wajib diisi bila terdapat :values.',
    'required_without'     => ':Attribute wajib diisi bila tidak terdapat :values.',
    'required_without_all' => ':Attribute wajib diisi bila sama sekali tidak terdapat :values.',
    'same'                 => ':Attribute dan :other harus sama.',
    'size'                 => [
        'array'   => ':Attribute harus mengandung :size data.',
        'file'    => ':Attribute harus berukuran :size kb.',
        'numeric' => ':Attribute harus :size.',
        'string'  => ':Attribute harus :size karakter.',
    ],
    'starts_with'          => ':Attribute harus diawali dengan: :values',
    'string'               => ':Attribute harus berupa string.',
    'timezone'             => ':Attribute harus berisi zona waktu.',
    'unique'               => ':Attribute sudah digunakan.',
    'uploaded'             => ':Attribute harus ada.',
    'url'                  => 'Format :attribute tidak valid.',
    'uuid'                 => ':Attribute harus merupakan UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom'               => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'name' => 'Nama'
    ],

];
