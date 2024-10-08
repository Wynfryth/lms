<table id="deleted_detail_table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3">
                Urutan
            </th>
            <th scope="col" class="px-6 py-3">
                Nama Materi
            </th>
            <th scope="col" class="px-6 py-3">
                File
            </th>
            <th scope="col" class="px-6 py-3">
                Bobot Nilai
            </th>
            <th scope="col" class="px-6 py-3">
                Perkiraan Waktu
            </th>
            <th scope="col" class="px-6 py-3">
                Aksi
            </th>
        </tr>
    </thead>
    <tbody>
        @forelse ($detail as $index => $value)
            @php
                $filename = explode(', ', $value->filename);
                $attachment = explode(', ', $value->attachment);
                $estimated_time = explode(', ', $value->estimated_time);
            @endphp
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700" row_id="{{$value->id}}">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{$value->order}}
                </th>
                <td class="px-6 py-4">
                    {{$value->name}}
                </td>
                <td class="px-6 py-4">
                    @if (count($filename) > 1)
                        <ul class="list-disc">
                            @foreach ($filename as $filename_index => $filename_item)
                            <li>
                                @if (substr($attachment[$filename_index], 0, 4) == 'http')
                                    <a href="{{$attachment[$filename_index]}}" target="_blank">{{$filename_item}}</a>
                                @else

                                @endif
                            </li>
                            @endforeach
                        </ul>
                    @else
                        <a href="{{$value->attachment}}" target="_blank">{{$value->filename}}</a>
                    @endif
                </td>
                <td class="px-6 py-4">
                    {{$value->scoring_weight}}
                </td>
                <td class="px-6 py-4">
                    @if (count($estimated_time) > 1)
                        <ul class="list-disc">
                            @foreach ($estimated_time as $estimated_time_item)
                            <li>
                                {{$estimated_time_item}}
                            </li>
                            @endforeach
                        </ul>
                    @else
                        {{$value->estimated_time}}
                    @endif
                </td>
                <td class="px-6 py-4">
                    <a href="#" class="font-medium text-emerald-600 dark:text-red-500 hover:underline pulihkan_detail" data-detail="{{$value->id}}">Pulihkan</a>
                </td>
            </tr>
        @empty
            <tr class="row_no_data">
                <td class="text-center" colspan="100%">Tidak ada data.</td>
            </tr>
        @endforelse
    </tbody>
</table>
<script>
    $(document).off('click', '.pulihkan_detail').on('click', '.pulihkan_detail', function(){
        var id = $(this).data('detail');
        // console.log(id);
        Swal.fire({
            icon: "question",
            title: "Pulihkan",
            text: "Yakin untuk memulihkan data yang dihapus?",
            showConfirmButton: true,
            confirmButtonText: "Ya",
            showDenyButton: true,
            denyButtonText: "Tidak",
            allowOutsideClick: false
        })
        .then((response)=>{
            if(response.isConfirmed){
                $.ajax({
                    async: false,
                    type: "POST",
                    url: "{{ route('academy_admin.studydet.recover') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id,
                    },
                    dataType: "JSON",
                    success: function (response) {
                        Swal.fire({
                            icon: "success",
                            title: "Sukses",
                            text: "Berhasil memulihkan data.",
                            allowOutsideClick: false,
                            confirmButtonText: "OK",
                            // background: "gray"
                        })
                        .then((feedback)=>{
                            if(feedback.isConfirmed){
                                window.location.href = "{{ route('academy_admin.studies.edit', isset($detail[0]->header_id) ? $detail[0]->header_id : '0' )}}"
                            }
                        })
                    }
                });
            }
        })
    })
</script>
