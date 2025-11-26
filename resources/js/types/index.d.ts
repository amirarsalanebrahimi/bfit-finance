import { InertiaLinkProps } from '@inertiajs/vue3';
import type { LucideIcon } from 'lucide-vue-next';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    direction: 'rtl' | 'ltr';
    side: 'right' | 'left';
    sidebarOpen: boolean;
};

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface Transaction {
    id: number;
    user: User;
    title: string;
    type: 'INCOME' | 'EXPENSE';
    amount: string;
    date: string;
    reference_number: numner;
    payee_payer: string;
    description: string;
    payment_method: string;
    tags: Tag[];
}

export interface Tag {
    id: number;
    name: string;
    color: string;
    description: string;
}

export type BreadcrumbItemType = BreadcrumbItem;
