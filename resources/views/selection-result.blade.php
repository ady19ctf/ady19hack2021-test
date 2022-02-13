<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vote Result') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- This example requires Tailwind CSS v2.0+ -->
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div><br></div>
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">rank</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">number of vote</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <script>
                                        var labels = [];
                                        var numofvote = [];
                                    </script>
                                    @foreach($candidate_data_with_realname as $index=>$candidate_data)
                                    <script>
                                        labels.push("{{$candidate_data['real_name']}}");
                                        numofvote.push({{$candidate_data['vote']}});
                                    </script>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="ml-4">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"> {{$index+1}} </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{$candidate_data['real_name']}}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{$candidate_data['vote']}}</div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div style="margin-top : 50px">
                              <canvas id="VoteResultChart"></canvas>
                              <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>   
                              <script>
                                //グラフを描画
                                var ctx = document.getElementById("VoteResultChart");
                                var myChart = new Chart(ctx, {
                                  type: 'bar',
                                  data : {
                                    labels: labels,
                                    datasets: [
                                      {
                                        label: 'Number of Votes',
                                        data: numofvote,
                                        backgroundColor: "rgba(0,0,255,0.5)",
                                        borderColor: "rgba(0,0,255,0.5)",          // 棒の枠線の色
                                        borderWidth: 2,                              // 枠線の太さ
                                        beginAtZero: true   // minimum value will be 0.
                                      },
                                    ]
                                  },
                                  options: {
                                    responsive: true,
                                    // maintainAspectRatio: false,
                                    scales: {
                                      yAxes: [{
                                        ticks: {
                                          beginAtZero:true
                                        }
                                      }]
                                    }
                                  }   
                                });
                              </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
