<!-- Lawyer Links -->
<a href="{{ route('lawyer.dashboard') }}" class="{{ request()->routeIs('lawyer.dashboard') ? 'bg-red-50 text-red-600 border-l-4 border-red-500' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} block pl-3 pr-4 py-2 text-base font-medium">
    Dashboard
</a>

<a href="{{ route('lawyer.payments.index') }}" class="{{ request()->routeIs('lawyer.payments*') ? 'bg-red-50 text-red-600 border-l-4 border-red-500' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} block pl-3 pr-4 py-2 text-base font-medium">
    Payment
</a>

<a href="{{ route('lawyer.documents.index') }}" class="{{ request()->routeIs('lawyer.documents*') ? 'bg-red-50 text-red-600 border-l-4 border-red-500' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} block pl-3 pr-4 py-2 text-base font-medium">
    Document
</a>

<a href="{{ route('lawyer.loan.status') }}" class="{{ request()->routeIs('lawyer.loan.status*') ? 'bg-red-50 text-red-600 border-l-4 border-red-500' : 'text-gray-700 hover:bg-gray-50 hover:text-red-600' }} block pl-3 pr-4 py-2 text-base font-medium">
    Loan Status
</a> 