import { Type } from 'main.core';
import { RestClient } from 'rest.client';
import { Store } from 'ui.vue3.vuex';

import { Core } from 'im.v2.application.core';
import { Logger } from 'im.v2.lib.logger';
import { RestMethod, UserRole } from 'im.v2.const';
import { Utils } from 'im.v2.lib.utils';
import { Analytics } from 'im.v2.lib.analytics';

import type { ChatConfig, RestChatConfig } from '../types/chat';

const PRIVATE_CHAT = 'CHAT';
const OPEN_CHAT = 'OPEN';

export class CreateService
{
	#restClient: RestClient;
	#store: Store;

	constructor()
	{
		this.#restClient = Core.getRestClient();
		this.#store = Core.getStore();
	}

	async createChat(chatConfig: ChatConfig): Promise<{ newDialogId: string, newChatId: number }>
	{
		Logger.warn('ChatService: createChat', chatConfig);

		const preparedFields = await this.#prepareFields(chatConfig);

		const createResult: RestResult = await this.#restClient.callMethod(RestMethod.imV2ChatAdd, {
			fields: preparedFields,
		}).catch((error) => {
			// eslint-disable-next-line no-console
			console.error('ChatService: createChat error:', error);
			throw new Error(error);
		});

		const { chatId: newChatId } = createResult.data();

		Logger.warn('ChatService: createChat result', newChatId);
		const newDialogId = `chat${newChatId}`;
		this.#addChatToModel(newDialogId, preparedFields);
		this.#sendAnalytics(newDialogId);

		return { newDialogId, newChatId };
	}

	async #prepareFields(chatConfig: ChatConfig): RestChatConfig
	{
		const preparedConfig = { ...chatConfig };
		if (preparedConfig.avatar)
		{
			preparedConfig.avatar = await Utils.file.getBase64(chatConfig.avatar);
		}

		preparedConfig.managers = preparedConfig.managers ?? [];
		preparedConfig.members = preparedConfig.members ?? [];
		const allMembers = [...preparedConfig.members, ...preparedConfig.managers];
		if (preparedConfig.ownerId)
		{
			allMembers.push(preparedConfig.ownerId);
		}
		preparedConfig.members = [...new Set(allMembers)];

		const result = {
			type: preparedConfig.type?.toUpperCase(),
			entityType: preparedConfig.entityType?.toUpperCase(),
			title: preparedConfig.title,
			avatar: preparedConfig.avatar,
			description: preparedConfig.description,
			users: preparedConfig.members,
			memberEntities: preparedConfig.memberEntities,
			managers: preparedConfig.managers,
			ownerId: preparedConfig.ownerId,
			searchable: preparedConfig.isAvailableInSearch ? 'Y' : 'N',
			manageUsersAdd: preparedConfig.manageUsersAdd,
			manageUsersDelete: preparedConfig.manageUsersDelete,
			manageUi: preparedConfig.manageUi,
			manageSettings: preparedConfig.manageSettings,
			manageMessages: preparedConfig.manageMessages,
			conferencePassword: preparedConfig.conferencePassword,
			copilotMainRole: preparedConfig.copilotMainRole,
		};

		Object.entries(result).forEach(([key, value]) => {
			if (Type.isUndefined(value))
			{
				delete result[key];
			}
		});

		return result;
	}

	#addChatToModel(newDialogId: string, chatConfig: RestChatConfig)
	{
		let chatType = chatConfig.searchable === 'Y' ? OPEN_CHAT : PRIVATE_CHAT;
		if (Type.isStringFilled(chatConfig.entityType))
		{
			chatType = chatConfig.entityType.toLowerCase();
		}

		if (Type.isStringFilled(chatConfig.type))
		{
			chatType = chatConfig.type.toLowerCase();
		}

		this.#store.dispatch('chats/set', {
			dialogId: newDialogId,
			type: chatType.toLowerCase(),
			name: chatConfig.title,
			userCounter: chatConfig.users.length,
			role: UserRole.owner,
			permissions: {
				manageUi: chatConfig.manageUi,
				manageSettings: chatConfig.manageSettings,
				manageUsersAdd: chatConfig.manageUsersAdd,
				manageUsersDelete: chatConfig.manageUsersDelete,
				manageMessages: chatConfig.manageMessages,
			},
		});
	}

	#sendAnalytics(dialogId)
	{
		Analytics.getInstance().onCreateChat(dialogId);
	}
}
