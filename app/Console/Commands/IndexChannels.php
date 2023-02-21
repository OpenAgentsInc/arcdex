<?php

namespace App\Console\Commands;

use App\Models\Channel;
use App\Services\WebSocketClientService;
use Illuminate\Console\Command;
use Throwable;

class IndexChannels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'index:channels';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes channels';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Indexing channels...');

        $relays = ["wss://nostr.slothy.win","wss://global.relay.red","wss://sg.qemura.xyz","wss://relay.nostr-latam.link","wss://nostr.phenomenon.space","wss://relay.current.fyi","wss://nostr-relay.derekross.me","wss://nostr.developer.li","wss://relay.taxi","wss://nostr.massmux.com","wss://nostr-relay.schnitzel.world","wss://nostr1.tunnelsats.com","wss://relay.nostr.com.au","wss://knostr.neutrine.com","wss://nostrical.com","wss://nostr.gromeul.eu","wss://relay.ryzizub.com","wss://nostr.bostonbtc.com","wss://nostr.supremestack.xyz","wss://relay.nostr.moe","wss://nostr-1.nbo.angani.co","wss://nostr.uselessshit.co","wss://nostr.adpo.co","wss://relay.bleskop.com","wss://nostr.easydns.ca","wss://nostr-pub1.southflorida.ninja","wss://nostr.600.wtf","wss://relay.nostr.vision","wss://nostream.nostr.parts","wss://nostr-relay.texashedge.xyz","wss://nostr.zkid.social","wss://nostream-production-f83d.up.railway.app","wss://relay1.gems.xyz","wss://nostream.nostrly.io","wss://nostr.terminus.money","wss://nostr.ltbl.io","wss://nostr.koning-degraaf.nl","wss://nostr.pleb.network","wss://nostr.cheeserobot.org","wss://relay.hamnet.io","wss://nostr.primz.org","wss://nostr.rajabi.ca","wss://nostr.sidnlabs.nl","wss://arc1.arcadelabs.co","wss://nostr.nym.life","wss://relay.nostr.distrl.net","wss://relay.727whisky.com","wss://relay.alien.blue","wss://atlas.nostr.land","wss://nostr.island.network","wss://relay.nostrati.com","wss://relay-dev.cowdle.gg","wss://relay.1bps.io","wss://relay.nostrich.land","wss://relay.nostrview.com","wss://nostr-relay.pcdkd.fyi","wss://www.131.me","wss://nostream.unift.xyz","wss://jp-relay-nostr.invr.chat","wss://nostr.nokotaro.com","wss://relay.humanumest.social","wss://relay.nostr.amane.moe","wss://nostream.lucas.snowinning.com","wss://nostream.frank.snowinning.com","wss://nostr-relay.aapi.me","wss://nostr-relay.nokotaro.com","wss://paid.spore.ws","wss://relay-local.cowdle.gg","wss://nostream-test.up.railway.app","wss://nostr-test.elastos.io","wss://nostr.buythisdip.com","wss://nostr.web3infra.xyz","wss://nostrafrica.pcdkd.fyi","wss://quirky-bunch-isubghsvoi26fbbt3n7o.wnext.app","wss://relay.stonez.me","wss://relay.reeve.cn","wss://nostr.monostr.com","wss://cheery-paddock-rsakdrtc35c55n6yregn.wnext.app","wss://nostr.geekgalaxy.com","wss://lightningrelay.com","wss://relay.nostr.or.jp","wss://relay.nostrified.org","wss://nostr-sg.com","wss://bitcoinmaximalists.online","wss://nostr.bitcoin-basel.ch","wss://free-relay.nostrich.land","wss://nostream.madbean.snowinning.com","wss://nostr.nostrelay.org","wss://nostr-1.afarazit.eu","wss://nostr-2.afarazit.eu","wss://nostr.lightning.contact","wss://nostream-relay-nostr.831.pp.ua","wss://relay.nostr.net.in","wss://private.red.gb.net","wss://nostream.dev.kronkltd.net","wss://nostr.thibautrey.fr","wss://nostr.kawagarbo.xyz","wss://relay.nostr3.io","wss://relay.nosbin.com","wss://rasca.asnubes.art","wss://relay.jig.works","wss://nostr.chainofimmortals.net","wss://relay.nostrcheck.me","wss://relay.nostr.vet","wss://lbrygen.xyz","wss://nostr.robotesc.ro","wss://relay.nostrdocs.com","wss://nostrue.com","wss://nostr.danvergara.com","wss://nostr.ownbtc.online","wss://nostr.ibosilj.work","wss://nostr-us.coinfundit.com","wss://nostr-eu.coinfundit.com","wss://alphapanda.pro","wss://nostr.zue.news","wss://nostream.megadope.snowinning.com","wss://nostr.topeth.info","wss://puravida.nostr.land","wss://public.nostr.swissrouting.com","wss://relay.orange-crush.com","wss://nostr.spaceshell.xyz","wss://nostr.fediverse.jp","wss://nostr.screaminglife.io","wss://nostr.arguflow.gg","wss://tmp-relay.cesc.trade","wss://nostr-au.coinfundit.com"];

        // loop through each relay
        for ($i = 0; $i < count($relays); $i++) {
            $relayUrl = $relays[$i];
            $this->indexChannels($relayUrl);
        }
    }

    protected function indexChannels($relayUrl) {
        $this->info("Indexing channels from {$relayUrl}...");
        $svc = new WebSocketClientService($relayUrl);
        try {
            $channelData = $svc->fetchRecentChannels();
        } catch (\WebSocket\TimeoutException $e) {
            $this->error("Timeout connecting to relay: {$relayUrl}");
            return;
        } catch (\WebSocket\ConnectionException $e) {
            $this->error("Connection error connecting to relay: {$relayUrl}");
            return;
        } catch (Throwable $e) {
            $this->error("Unknown error connecting to relay: {$relayUrl}");
            return;
        }

        $channels = [];
        foreach ($channelData as $data) {
            $content = json_decode($data['content'], true);
            try {
                $channel = Channel::create([
                    'title' => $content['name'] ?? '',
                    'relayurl' => $relayUrl,
                    'eventid' => $data['id'],
                ]);
                array_push($channels, $channel);
            } catch (\Illuminate\Database\QueryException $e) {
                $this->warn("Channel already exists: {$content['name']}");
            }
        }

        $this->info("Indexed " . count($channels) . " channels from {$relayUrl}.");
        return $channels;
    }
}
