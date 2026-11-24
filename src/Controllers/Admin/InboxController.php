<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Core\DB;
use App\Core\Paginator;

final class InboxController extends Controller
{
    public function messages(): void
    {
        $total = (int) DB::value('SELECT COUNT(*) FROM contact_messages');
        $pager = new Paginator($total, 25);
        $this->admin('inbox/messages', [
            'title' => 'Messages', 'active' => 'messages', 'pager' => $pager,
            'messages' => DB::all('SELECT * FROM contact_messages ORDER BY is_read ASC, created_at DESC LIMIT :l OFFSET :o', ['l' => $pager->perPage, 'o' => $pager->offset]),
        ]);
    }

    public function message(string $id): void
    {
        $m = DB::one('SELECT * FROM contact_messages WHERE id = :id', ['id' => (int) $id]);
        if (!$m) {
            abort(404);
        }
        DB::update('contact_messages', ['is_read' => 1], 'id = :id', ['id' => $m['id']]);
        $this->admin('inbox/message', ['title' => 'Message from ' . $m['name'], 'active' => 'messages', 'm' => $m]);
    }

    public function deleteMessage(string $id): void
    {
        DB::delete('contact_messages', 'id = :id', ['id' => (int) $id]);
        flash('success', 'Message deleted.');
        redirect('/admin/messages');
    }

    public function newsletter(): void
    {
        $where = '1=1';
        $params = [];
        if (($q = trim((string) input('q', ''))) !== '') {
            $where = 'email LIKE :q';
            $params['q'] = '%' . addcslashes($q, '%_\\') . '%';
        }
        $total = (int) DB::value("SELECT COUNT(*) FROM newsletter_subscribers WHERE {$where}", $params);
        $pager = new Paginator($total, 50);
        $this->admin('inbox/newsletter', [
            'title' => 'Newsletter', 'active' => 'newsletter', 'pager' => $pager,
            'active_count' => (int) DB::value("SELECT COUNT(*) FROM newsletter_subscribers WHERE status = 'subscribed'"),
            'subscribers' => DB::all("SELECT * FROM newsletter_subscribers WHERE {$where} ORDER BY created_at DESC LIMIT :l OFFSET :o", $params + ['l' => $pager->perPage, 'o' => $pager->offset]),
        ]);
    }

    public function newsletterExport(): void
    {
        $rows = DB::all("SELECT email, status, created_at FROM newsletter_subscribers ORDER BY created_at DESC");
        csv_download('newsletter-' . date('Ymd') . '.csv', ['Email', 'Status', 'Subscribed at'], array_map('array_values', $rows));
    }

    public function newsletterDelete(string $id): void
    {
        DB::delete('newsletter_subscribers', 'id = :id', ['id' => (int) $id]);
        flash('success', 'Subscriber removed.');
        redirect('/admin/newsletter');
    }
}
